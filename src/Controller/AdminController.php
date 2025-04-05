<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    private EntityManagerInterface $em; // Handles database interactions like fetching, saving, and deleting

    /**
     * The constructor runs automatically when this controller is created.
     * We use it to pass in the EntityManager, which we'll need for database operations.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Admin Dashboard.
     * This page shows all the users and is restricted to admins only.
     */
    #[Route('/admin', name: 'admin_dashboard')]
    public function adminDashboard(): Response
    {
        // Only admins should be able to access this page
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Fetch all the users from the database
        $users = $this->em->getRepository(User::class)->findAll();

        // Pass the users to the dashboard template for display
        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * Update User Roles.
     * This function processes the form submission from the admin dashboard
     * to update the roles of users.
     */
    #[Route('/admin/users/update', name: 'admin_update_users', methods: ['POST'])]
    public function updateUsers(Request $request): Response
    {
        // Make sure only admins can do this
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Get the submitted data from the form (it will be an array of users)
        $submittedData = $request->request->all('users');

        foreach ($submittedData as $userId => $userData) {
            // Fetch the user from the database using their ID
            $user = $this->em->getRepository(User::class)->find($userId);

            if ($user) {
                // Check if the 'roles' field is in the submitted data
                if (isset($userData['roles'])) {
                    // Update the user's roles (split the string into an array)
                    $roles = array_map('trim', explode(',', $userData['roles']));
                    $user->setRoles($roles);
                }
            }
        }

        // Save all the changes to the database
        $this->em->flush();

        // Show a success message on the dashboard
        $this->addFlash('success', 'User details updated successfully.');

        // Redirect back to the admin dashboard
        return $this->redirectToRoute('admin_dashboard');
    }
}
