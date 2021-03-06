<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101141335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id VARCHAR(36) NOT NULL, product_id VARCHAR(36) NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_C53D045F4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id VARCHAR(36) NOT NULL, product_id VARCHAR(36) NOT NULL, code VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, sizes LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_D79572D94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id VARCHAR(36) NOT NULL, series_id VARCHAR(36) NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_D34A04AD5278319C (series_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id VARCHAR(36) NOT NULL, model_id VARCHAR(36) NOT NULL, name VARCHAR(100) NOT NULL, value VARCHAR(100) NOT NULL, INDEX IDX_8BF21CDE7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series (id VARCHAR(36) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD5278319C FOREIGN KEY (series_id) REFERENCES series (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE7975B7E7');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4584665A');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D94584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD5278319C');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE series');
    }
}
