<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\ContactType;
use App\Form\ProductType;
use App\Form\CategoryType;
use App\Repository\UserRepository;
use App\Repository\ContactRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminController extends AbstractController
{

    // Route de base :

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    // Routes d'affichage :

    #[Route('/admin/produit/afficher', name: 'admin_produit_afficher')]
    // $pR sert à renommer ProductRepository le temps de notre fonction, c'est un objet
    public function display_products(ProductRepository $pR): Response
    {
        $products = $pR->findAll();


        return $this->render('admin/produits.html.twig', [
          
            "produits" => $products

        ]);
    }

    #[Route('/admin/contact/afficher', name: 'admin_contact_afficher')]
    // $pR sert à renommer ProductRepository le temps de notre fonction, c'est un objet
    public function display_contacts(ContactRepository $cR): Response
    {
        $contacts = $cR->findAll();


        return $this->render('admin/contacts.html.twig', [
          
            "contacts" => $contacts

        ]);
    }

    

    #[Route('/admin/category/afficher', name: 'admin_category_afficher')]
    // $pR sert à renommer ProductRepository le temps de notre fonction, c'est un objet
    public function display_categories(CategoryRepository $catR): Response
    {
        $categories = $catR->findAll();


        return $this->render('admin/categories.html.twig', [
          
            "categories" => $categories

        ]);
    }

    // Routes d'affichage par Id :

    #[Route('/admin/produits/afficher/{id}', name: 'admin_produits_afficher_id')]
    public function afficher_produits_id($id, ProductRepository $repoProd): Response
    {
        $product = $repoProd->find($id);

        dump($product);
        return $this->render('admin/productId.html.twig', [
       
            "prod" => $product

        ]);
    }

    #[Route('/admin/contacts/afficher/{id}', name: 'admin_contacts_afficher_id')]
    public function afficher_contacts_id($id, ContactRepository $repoCont): Response
    {
        $contact = $repoCont->find($id);

        dump($contact);
        return $this->render('admin/contactId.html.twig', [
       
            "cont" => $contact

        ]);
    }

    #[Route('/admin/category/afficher/{id}', name: 'admin_category_afficher_id')]
    public function afficher_categories_id($id, CategoryRepository $repoCat): Response
    {
        $category = $repoCat->find($id);

        dump($category);
        return $this->render('admin/categoryId.html.twig', [
       
            "cat" => $category

        ]);
    }

    // Routes d'ajout :

    #[Route('/admin/produit/ajouter', name: 'admin_product_ajouter')]
    public function ajouter_product(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        
           /*  dd($request); */
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', "Product ajoutée en BDD !" );
            return $this->redirectToRoute('accueil');
        }
      
        return $this->render('admin/ajoutProduit.html.twig', [
            
            "formProduct" => $form->createView(),
           /*  "contact" => $contact */

        ]);
    }

    #[Route('/admin/contact/ajouter', name: 'admin_contact_ajouter')]
    public function ajouter_contact(Request $request, EntityManagerInterface $manager): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        
           /*  dd($request); */
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash('success', "Contact ajoutée en BDD !" );
            return $this->redirectToRoute('accueil');
        }
      
        return $this->render('admin/ajoutContact.html.twig', [
            
            "formContact" => $form->createView(),
           /*  "contact" => $contact */

        ]);
    }



    #[Route('/admin/category/ajouter', name: 'admin_category_ajouter')]
    public function ajouter_category(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        
           /*  dd($request); */
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', "Catégorie " . $category->getTitle() . " ajoutée en BDD !" );
            return $this->redirectToRoute('accueil');
        }
      
        return $this->render('admin/ajoutCategorie.html.twig', [
            
            "formCategory" => $form->createView(),
           /*  "contact" => $contact */

        ]);
    }

    // Routes d'édition :

    #[Route('/admin/produit/editer/{id}', name: 'admin_product_editer')]
    public function editer_products(Product $product, Request $request, EntityManagerInterface $manager): Response
    {

        /* dd($contact); */

        $form = $this->createForm(ProductType::class, $product);

        
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $manager->persist($product);
            $manager->flush();
            
            $this->addFlash("success", "Votre fiche produit a bien été modifiée !");
            
            return $this->redirectToRoute('accueil');
        }

        
        return $this->render('admin/editProduit.html.twig', [
            'formProd' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/admin/contact/editer/{id}', name: 'admin_contact_editer')]
    public function editer_contact(Contact $contact, Request $request, EntityManagerInterface $manager): Response
    {

        /* dd($contact); */

        $form = $this->createForm(ContactType::class, $contact);

        
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $manager->persist($contact);
            $manager->flush();
            
            $this->addFlash("success", "Votre fiche contact a bien été modifiée !");
            
            return $this->redirectToRoute('accueil');
        }

        
        return $this->render('admin/editContact.html.twig', [
            'formCont' => $form->createView(),
            'contact' => $contact,
        ]);
    }



    #[Route('/admin/category/editer/{id}', name: 'admin_category_editer')]
    public function editer_categories(Category $category, Request $request, EntityManagerInterface $manager): Response
    {

        /* dd($contact); */

        $form = $this->createForm(CategoryType::class, $category);

        
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $manager->persist($category);
            $manager->flush();
            
            $this->addFlash("success", "Votre fiche category a bien été modifiée  " . $category->getTitle() . " !");
            
            return $this->redirectToRoute('accueil');
        }

        
        return $this->render('admin/editCategory.html.twig', [
            'formCat' => $form->createView(),
            'category' => $category,
        ]);
    }

    #[Route('/admin/category/supprimer/{id}', name: 'admin_category_supprimer')]
    public function supprimer_category(Category $category, EntityManagerInterface $manager): Response
    {

       

        $manager->remove($category);
        $manager->flush();

        $this->addFlash("success", "Votre fiche catégorie a été supprimée !");

        return $this->redirectToRoute('accueil');
 
}

#[Route('/admin/contact/supprimer/{id}', name: 'admin_contact_supprimer')]
public function supprimer_contact(Contact $contact, EntityManagerInterface $manager): Response
{

   

    $manager->remove($contact);
    $manager->flush();

    $this->addFlash("success", "Votre fiche contact a été supprimée !");

    return $this->redirectToRoute('accueil');

}

#[Route('/admin/produit/supprimer/{id}', name: 'admin_produit_supprimer')]
public function supprimer_produit(Product $product, EntityManagerInterface $manager): Response
{

   

    $manager->remove($product);
    $manager->flush();

    $this->addFlash("success", "Votre fiche produit a été supprimée !");

    return $this->redirectToRoute('accueil');

}

#[Route('/admin/admins', name: 'admin_admins_afficher')]
public function afficher_admins(UserRepository $userRepository): Response
{

    $admins = $userRepository->findByMail("admin@admin.admin"); 
   $rolesAdmin = $userRepository->findByRole('admin');
   

    return $this->render('admin/afficherAdmins.html.twig', [
         'admins' => $admins,
        'rolesAdmins' => $rolesAdmin
     ]);
}



















#[Route('/admin/city_users', name: 'admin_city_users_afficher')]
public function afficher_city_users(UserRepository $userRepository): Response
{

   /* $admins = $userRepository->findByMail("admin@admin.admin"); */
   $cityUsers = $userRepository->findByCity('Lille');
   

    return $this->render('admin/afficherUsersParVille.html.twig', [
        /* 'admins' => $admins, */
        'cityUsers' => $cityUsers
    ]);
}














#[Route('/admin/city_role_users', name: 'admin_city_role_users_afficher')]
public function afficher_city_roles_users(UserRepository $userRepository): Response
{

   /* $admins = $userRepository->findByMail("admin@admin.admin"); */
   $cityRoleUsers = $userRepository->findByRoleAndCity('admin', 'Lille');
   

    return $this->render('admin/afficherUsersParVilleEtRole.html.twig', [
        /* 'admins' => $admins, */
        'cityRoleUsers' => $cityRoleUsers
    ]);
}

#[Route('/admin/products', name: 'admin_products_price')]
public function afficher_produuits_prix(ProductRepository $prodRepository): Response
{

    $prices = $prodRepository->findByPrice(2000); 
    $catProd = $prodRepository->findByCat(3);
   

    return $this->render('admin/afficherParPrix.html.twig', [
         'prices' => $prices,
        'catProd' => $catProd
     ]);
}

    
    


}
