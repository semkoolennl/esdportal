<?php

declare(strict_types=1);

namespace App\Migrations\Eset;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318134749 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE CompanyDetails (id INT AUTO_INCREMENT NOT NULL, companyId INT NOT NULL, mollieKey VARCHAR(255) DEFAULT NULL, mollieTestKey VARCHAR(255) DEFAULT NULL, esetGuid VARCHAR(255) DEFAULT NULL, esetKey VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CompanyProductDetailsLink (id INT AUTO_INCREMENT NOT NULL, visible TINYINT(1) NOT NULL, companyDetails_id INT DEFAULT NULL, productDetails_id INT NOT NULL, INDEX IDX_6E1AED358AC02F1F (companyDetails_id), INDEX IDX_6E1AED35D77B1362 (productDetails_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Product (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, name VARCHAR(255) NOT NULL, upgrades LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ProductDetails (id INT AUTO_INCREMENT NOT NULL, standard TINYINT(1) NOT NULL, version VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, headerImage VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, tags LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, mollieId VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', status VARCHAR(255) NOT NULL, companyDetails_id INT DEFAULT NULL, INDEX IDX_F52993988AC02F1F (companyDetails_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE CompanyProductDetailsLink ADD CONSTRAINT FK_6E1AED358AC02F1F FOREIGN KEY (companyDetails_id) REFERENCES CompanyDetails (id)');
        $this->addSql('ALTER TABLE CompanyProductDetailsLink ADD CONSTRAINT FK_6E1AED35D77B1362 FOREIGN KEY (productDetails_id) REFERENCES ProductDetails (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988AC02F1F FOREIGN KEY (companyDetails_id) REFERENCES CompanyDetails (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE CompanyProductDetailsLink DROP FOREIGN KEY FK_6E1AED358AC02F1F');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988AC02F1F');
        $this->addSql('ALTER TABLE CompanyProductDetailsLink DROP FOREIGN KEY FK_6E1AED35D77B1362');
        $this->addSql('DROP TABLE CompanyDetails');
        $this->addSql('DROP TABLE CompanyProductDetailsLink');
        $this->addSql('DROP TABLE Product');
        $this->addSql('DROP TABLE ProductDetails');
        $this->addSql('DROP TABLE `order`');
    }
}
