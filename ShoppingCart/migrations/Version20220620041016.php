<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620041016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, email_id INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_BA388B7A832C1C9 (email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_product (cart_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_2890CCAA1AD5CDBF (cart_id), INDEX IDX_2890CCAA4584665A (product_id), PRIMARY KEY(cart_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, cat_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, email_id INT NOT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(11) NOT NULL, UNIQUE INDEX UNIQ_81398E09A832C1C9 (email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, email_id INT NOT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, phone VARCHAR(11) NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1A832C1C9 (email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_info (id INT AUTO_INCREMENT NOT NULL, email_id INT NOT NULL, order_id VARCHAR(255) NOT NULL, quantity INT NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_86780B40A832C1C9 (email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_info_product (order_info_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_554FB959ABF168B3 (order_info_id), INDEX IDX_554FB9594584665A (product_id), PRIMARY KEY(order_info_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, cat_id_id INT NOT NULL, product_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, info VARCHAR(255) NOT NULL, INDEX IDX_D34A04ADC33F2EBA (cat_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A832C1C9 FOREIGN KEY (email_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A832C1C9 FOREIGN KEY (email_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A832C1C9 FOREIGN KEY (email_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_info ADD CONSTRAINT FK_86780B40A832C1C9 FOREIGN KEY (email_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE order_info_product ADD CONSTRAINT FK_554FB959ABF168B3 FOREIGN KEY (order_info_id) REFERENCES order_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_info_product ADD CONSTRAINT FK_554FB9594584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC33F2EBA FOREIGN KEY (cat_id_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA1AD5CDBF');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC33F2EBA');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A832C1C9');
        $this->addSql('ALTER TABLE order_info DROP FOREIGN KEY FK_86780B40A832C1C9');
        $this->addSql('ALTER TABLE order_info_product DROP FOREIGN KEY FK_554FB959ABF168B3');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA4584665A');
        $this->addSql('ALTER TABLE order_info_product DROP FOREIGN KEY FK_554FB9594584665A');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A832C1C9');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1A832C1C9');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE order_info');
        $this->addSql('DROP TABLE order_info_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE user');
    }
}
