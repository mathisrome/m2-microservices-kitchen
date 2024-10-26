<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241023210508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', client_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_plate (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, plate_id INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_F200A3A68D9F6D38 (order_id), INDEX IDX_F200A3A6DF66E98B (plate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_plate ADD CONSTRAINT FK_F200A3A68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_plate ADD CONSTRAINT FK_F200A3A6DF66E98B FOREIGN KEY (plate_id) REFERENCES plate (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_plate DROP FOREIGN KEY FK_F200A3A68D9F6D38');
        $this->addSql('ALTER TABLE order_plate DROP FOREIGN KEY FK_F200A3A6DF66E98B');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_plate');
        $this->addSql('DROP TABLE plate');
    }
}
