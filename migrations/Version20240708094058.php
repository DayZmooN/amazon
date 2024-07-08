<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708094058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, merchant_id INT NOT NULL, category_article_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, stock INT NOT NULL, img_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_23A0E666796D554 (merchant_id), INDEX IDX_23A0E66548AD6E2 (category_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_order (article_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_829EE1897294869C (article_id), INDEX IDX_829EE1898D9F6D38 (order_id), PRIMARY KEY(article_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, order_invoice_id INT NOT NULL, created_at DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_906517449A530CA8 (order_invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE merchant (id INT AUTO_INCREMENT NOT NULL, user_merchant_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_74AB25E1CE8D1CC1 (user_merchant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, total_price NUMERIC(10, 2) NOT NULL, date DATETIME NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666796D554 FOREIGN KEY (merchant_id) REFERENCES merchant (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66548AD6E2 FOREIGN KEY (category_article_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE article_order ADD CONSTRAINT FK_829EE1897294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_order ADD CONSTRAINT FK_829EE1898D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517449A530CA8 FOREIGN KEY (order_invoice_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE merchant ADD CONSTRAINT FK_74AB25E1CE8D1CC1 FOREIGN KEY (user_merchant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666796D554');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66548AD6E2');
        $this->addSql('ALTER TABLE article_order DROP FOREIGN KEY FK_829EE1897294869C');
        $this->addSql('ALTER TABLE article_order DROP FOREIGN KEY FK_829EE1898D9F6D38');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517449A530CA8');
        $this->addSql('ALTER TABLE merchant DROP FOREIGN KEY FK_74AB25E1CE8D1CC1');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_order');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE merchant');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE user');
    }
}
