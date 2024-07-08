<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Merchant;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Order;
use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Users
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@example.com");
            $hashedPassword = $this->passwordHasher->hashPassword($user, "password{$i}");
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user;
        }

        // Merchants
        $merchants = [];
        for ($i = 1; $i <= 3; $i++) {
            $merchant = new Merchant();
            $merchant->setName("Merchant {$i}");
            $merchant->setEmail("merchant{$i}@example.com");
            $merchant->setAddress("123 Merchant Street {$i}");
            $merchant->setCreatedAt(new \DateTimeImmutable());
            $merchant->setUserMerchant($users[$i - 1]); // Assign a user to each merchant
            $manager->persist($merchant);
            $merchants[] = $merchant;
        }

        // Categories
        $categories = [];
        $categoryNames = ['Electronics', 'Books', 'Clothing', 'Home', 'Toys'];
        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Articles
        $articles = [];
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setName("Article {$i}");
            $article->setPrice(mt_rand(10, 100));
            $article->setStock(mt_rand(0, 50));
            $article->setImgUrl("https://example.com/image{$i}.jpg");
            $article->setCreatedAt(new \DateTime());
            $article->setDescription("Description for article {$i}");
            $article->setMerchant($merchants[array_rand($merchants)]);
            $article->setCategoryArticle($categories[array_rand($categories)]);
            $manager->persist($article);
            $articles[] = $article;
        }

        // Orders
        $orders = [];
        for ($i = 1; $i <= 5; $i++) {
            $order = new Order();
            $order->setUser($users[array_rand($users)]);
            $order->setStatus('Pending');
            $order->setTotalPrice(mt_rand(50, 200));
            $order->setDate(new \DateTime());
            $manager->persist($order);
            $orders[] = $order;
        }

        // Invoices
        foreach ($orders as $order) {
            $invoice = new Invoice();
            $invoice->setOrderInvoice($order);
            $invoice->setCreatedAt(new \DateTime());
            $invoice->setAmount($order->getTotalPrice());
            $manager->persist($invoice);
        }

        $manager->flush();
    }
}
