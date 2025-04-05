<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Review;
use App\Form\BlogFormType;
use App\Form\ReviewFormType;
use App\Form\SearchFormType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private EntityManagerInterface $em; // Handles saving, updating, and deleting in the database
    private BlogRepository $blogRepository; // Lets us fetch blogs from the database

    public function __construct(EntityManagerInterface $em, BlogRepository $blogRepository) 
    {
        $this->em = $em;
        $this->blogRepository = $blogRepository;
    }

    #[Route('/blogs', name: 'blog_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $searchForm = $this->createForm(SearchFormType::class);
        $searchForm->handleRequest($request);

        $blogs = [];

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $title = $searchForm->get('title')->getData();
            $blogs = $this->blogRepository->findByTitle($title);
        } else {
            $blogs = $this->blogRepository->findAll();
        }

        return $this->render('blogs/index.html.twig', [
            'blogs' => $blogs,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('/blogs/create', name: 'blog_create')]
    public function create(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogFormType::class, $blog);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imagePath')->getData();
    
            if ($image) {
                // Ensure the uploads directory exists
                $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
                }
    
                // Generate a unique filename
                $newFilename = uniqid() . '.' . $image->guessExtension();
    
                try {
                    // Move the uploaded file
                    $image->move($uploadDir, $newFilename);
                    $blog->setImagePath('/uploads/' . $newFilename);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Failed to upload image: ' . $e->getMessage());
                }
            }
    
            $this->em->persist($blog);
            $this->em->flush();
    
            return $this->redirectToRoute('blog_index');
        }
    
        return $this->render('blogs/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/uploads/{filename}', name: 'uploaded_file')]
    public function serveImage($filename): Response
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $filename;
    
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException();
        }
    
        return new BinaryFileResponse($filePath);
    }
    

    #[Route('/blogs/{id}', name: 'blog_show', methods: ['GET', 'POST'])]
    public function show(Request $request, $id): Response
    {
        $blog = $this->blogRepository->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Blog not found');
        }

        $review = new Review();
        $review->setBlog($blog);
        $form = $this->createForm(ReviewFormType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($review);
            $this->em->flush();
            return $this->redirectToRoute('blog_show', ['id' => $id]);
        }

        return $this->render('blogs/show.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/blogs/delete/{id}', methods: ['GET', 'DELETE'], name: 'blog_delete')]
    public function delete($id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Access Denied.');
        $blog = $this->blogRepository->find($id);

        if ($blog) {
            $this->em->remove($blog);
            $this->em->flush();
        }

        return $this->redirectToRoute('blog_index');
    }

    #[Route('/blogs/edit/{id}', name: 'blog_edit')]
public function edit(Request $request, $id): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Access Denied.');
    $blog = $this->blogRepository->find($id);

    if (!$blog) {
        throw $this->createNotFoundException('The blog does not exist');
    }

    $form = $this->createForm(BlogFormType::class, $blog);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle image upload
        $image = $form->get('imagePath')->getData();
        if ($image) {
            // Delete old image if exists
            if ($blog->getImagePath() && file_exists(
                $this->getParameter('kernel.project_dir') . $blog->getImagePath()
            )) {
                unlink($this->getParameter('kernel.project_dir') . $blog->getImagePath());
            }

            // Upload new image
            $newFilename = uniqid().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('kernel.project_dir') . '/public/uploads',
                $newFilename
            );
            $blog->setImagePath('/uploads/' . $newFilename);
        }

        $this->em->flush();
        return $this->redirectToRoute('blog_show', ['id' => $blog->getId()]);
    }

    return $this->render('blogs/edit.html.twig', [
        'form' => $form->createView(),
        'blog' => $blog
    ]);
}

#[Route('/reviews/edit/{id}', name: 'review_edit')]
public function editReview(Request $request, Review $review, EntityManagerInterface $em): Response
{
    $form = $this->createForm(ReviewFormType::class, $review);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('blog_show', ['id' => $review->getBlog()->getId()]);
    }

    return $this->render('reviews/edit.html.twig', [
        'form' => $form->createView(),
        'review' => $review,
    ]);
}


}
