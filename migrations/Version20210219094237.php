<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219094237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, date_post DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, commentaire LONGTEXT NOT NULL, utilisateur INT NOT NULL, reponse LONGTEXT DEFAULT NULL, date DATE NOT NULL, article VARCHAR(255) NOT NULL, note INT DEFAULT NULL, nb_like INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status SMALLINT DEFAULT NULL, type SMALLINT DEFAULT NULL, price NUMERIC(8, 0) NOT NULL, certified TINYINT(1) NOT NULL, min_duration SMALLINT DEFAULT NULL, max_duration SMALLINT DEFAULT NULL, cancellation_policy SMALLINT DEFAULT NULL, average_rating SMALLINT DEFAULT NULL, comment_count INT DEFAULT NULL, admin_notation NUMERIC(3, 1) DEFAULT NULL, availabilities_updated_at DATETIME DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX status_l_idx (status), INDEX min_duration_idx (min_duration), INDEX admin_notation_idx (admin_notation), INDEX IDX_CB0048D4A76ED395 (user_id), INDEX price_idx (price), INDEX max_duration_idx (max_duration), INDEX created_at_l_idx (createdAt), INDEX type_idx (type), INDEX average_rating_idx (average_rating), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participations (listing_id INT NOT NULL, mariage_id INT NOT NULL, INDEX IDX_FDC6C6E8D4619D1A (listing_id), INDEX IDX_FDC6C6E8192813B (mariage_id), PRIMARY KEY(listing_id, mariage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_listing_category (listing_id INT NOT NULL, listing_category_id INT NOT NULL, INDEX IDX_1AFD54EAD4619D1A (listing_id), INDEX IDX_1AFD54EA455844B0 (listing_category_id), PRIMARY KEY(listing_id, listing_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, texte LONGTEXT DEFAULT NULL, texteaccueil LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, imageaccueil VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description TINYTEXT DEFAULT NULL, accueil TINYINT(1) DEFAULT NULL, lft INT DEFAULT NULL, lvl INT DEFAULT NULL, rgt INT DEFAULT NULL, root INT DEFAULT NULL, INDEX IDX_E0307BBB727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX name_idx (name), INDEX IDX_606EDC1F2C2AC5D3 (translatable_id), UNIQUE INDEX listing_category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_image (id INT AUTO_INCREMENT NOT NULL, listing_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position SMALLINT NOT NULL, INDEX IDX_33D3DCD3D4619D1A (listing_id), INDEX position_li_idx (position), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, description TEXT DEFAULT NULL, rules TEXT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) DEFAULT NULL, INDEX slug_idx (slug), INDEX IDX_E3779C3D2C2AC5D3 (translatable_id), UNIQUE INDEX listing_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mariage (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(40) NOT NULL, texte LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, traduction VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, imageaccueil VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, header LONGTEXT NOT NULL, footer LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, nationality VARCHAR(255) NOT NULL, countryofresidence VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, phone VARCHAR(10) NOT NULL, profession VARCHAR(255) NOT NULL, persontype INT NOT NULL, email VARCHAR(255) NOT NULL, createdat DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_address (id INT AUTO_INCREMENT NOT NULL, images_id INT DEFAULT NULL, addresses_id INT DEFAULT NULL, user_id INT DEFAULT NULL, type SMALLINT DEFAULT 1 NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, zip VARCHAR(50) DEFAULT NULL, country VARCHAR(3) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_5543718BD44F05E5 (images_id), INDEX IDX_5543718B5713BC80 (addresses_id), INDEX IDX_5543718BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_image (id INT AUTO_INCREMENT NOT NULL, images_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position SMALLINT NOT NULL, INDEX IDX_27FFFF07D44F05E5 (images_id), INDEX IDX_27FFFF07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E8D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E8192813B FOREIGN KEY (mariage_id) REFERENCES mariage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE listing_listing_category ADD CONSTRAINT FK_1AFD54EAD4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE listing_listing_category ADD CONSTRAINT FK_1AFD54EA455844B0 FOREIGN KEY (listing_category_id) REFERENCES listing_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE listing_category ADD CONSTRAINT FK_E0307BBB727ACA70 FOREIGN KEY (parent_id) REFERENCES listing_category (id)');
        $this->addSql('ALTER TABLE listing_category_translation ADD CONSTRAINT FK_606EDC1F2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES listing_category (id)');
        $this->addSql('ALTER TABLE listing_image ADD CONSTRAINT FK_33D3DCD3D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE listing_translation ADD CONSTRAINT FK_E3779C3D2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BD44F05E5 FOREIGN KEY (images_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718B5713BC80 FOREIGN KEY (addresses_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07D44F05E5 FOREIGN KEY (images_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participations DROP FOREIGN KEY FK_FDC6C6E8D4619D1A');
        $this->addSql('ALTER TABLE listing_listing_category DROP FOREIGN KEY FK_1AFD54EAD4619D1A');
        $this->addSql('ALTER TABLE listing_image DROP FOREIGN KEY FK_33D3DCD3D4619D1A');
        $this->addSql('ALTER TABLE listing_translation DROP FOREIGN KEY FK_E3779C3D2C2AC5D3');
        $this->addSql('ALTER TABLE listing_listing_category DROP FOREIGN KEY FK_1AFD54EA455844B0');
        $this->addSql('ALTER TABLE listing_category DROP FOREIGN KEY FK_E0307BBB727ACA70');
        $this->addSql('ALTER TABLE listing_category_translation DROP FOREIGN KEY FK_606EDC1F2C2AC5D3');
        $this->addSql('ALTER TABLE participations DROP FOREIGN KEY FK_FDC6C6E8192813B');
        $this->addSql('ALTER TABLE listing DROP FOREIGN KEY FK_CB0048D4A76ED395');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718BD44F05E5');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718B5713BC80');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718BA76ED395');
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF07D44F05E5');
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF07A76ED395');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE listing');
        $this->addSql('DROP TABLE participations');
        $this->addSql('DROP TABLE listing_listing_category');
        $this->addSql('DROP TABLE listing_category');
        $this->addSql('DROP TABLE listing_category_translation');
        $this->addSql('DROP TABLE listing_image');
        $this->addSql('DROP TABLE listing_translation');
        $this->addSql('DROP TABLE mariage');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_address');
        $this->addSql('DROP TABLE user_image');
    }
}
