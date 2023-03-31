<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329161806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, desks_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_3FB7A2BF6BD33809 (desks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bookings (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, desks_id INT DEFAULT NULL, note INT NOT NULL, price DOUBLE PRECISION NOT NULL, opinion VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, created DATETIME NOT NULL, INDEX IDX_7A853C3567B3B43D (users_id), INDEX IDX_7A853C356BD33809 (desks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE desks (id INT AUTO_INCREMENT NOT NULL, owners_id INT DEFAULT NULL, status_desks_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, adress VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, zip_code VARCHAR(25) NOT NULL, description VARCHAR(255) NOT NULL, number_places INT NOT NULL, tax INT NOT NULL, INDEX IDX_BFDA6542236ECBFC (owners_id), INDEX IDX_BFDA6542F6099FD1 (status_desks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE desks_options (desks_id INT NOT NULL, options_id INT NOT NULL, INDEX IDX_37791DA46BD33809 (desks_id), INDEX IDX_37791DA43ADB05F1 (options_id), PRIMARY KEY(desks_id, options_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, desks_id INT DEFAULT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A6BD33809 (desks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE options (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D035FA875E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_desks (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, status_users_id INT DEFAULT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, gender VARCHAR(50) NOT NULL, nationality VARCHAR(50) NOT NULL, birth_date VARCHAR(30) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, access DATETIME NOT NULL, created DATETIME NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', is_certified TINYINT(1) NOT NULL, adress VARCHAR(255) NOT NULL, zip_code VARCHAR(6) NOT NULL, city VARCHAR(255) NOT NULL, phone_number VARCHAR(21) NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E9FA6913E5 (status_users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BF6BD33809 FOREIGN KEY (desks_id) REFERENCES desks (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C3567B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C356BD33809 FOREIGN KEY (desks_id) REFERENCES desks (id)');
        $this->addSql('ALTER TABLE desks ADD CONSTRAINT FK_BFDA6542236ECBFC FOREIGN KEY (owners_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE desks ADD CONSTRAINT FK_BFDA6542F6099FD1 FOREIGN KEY (status_desks_id) REFERENCES status_desks (id)');
        $this->addSql('ALTER TABLE desks_options ADD CONSTRAINT FK_37791DA46BD33809 FOREIGN KEY (desks_id) REFERENCES desks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE desks_options ADD CONSTRAINT FK_37791DA43ADB05F1 FOREIGN KEY (options_id) REFERENCES options (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A6BD33809 FOREIGN KEY (desks_id) REFERENCES desks (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9FA6913E5 FOREIGN KEY (status_users_id) REFERENCES status_users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BF6BD33809');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C3567B3B43D');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C356BD33809');
        $this->addSql('ALTER TABLE desks DROP FOREIGN KEY FK_BFDA6542236ECBFC');
        $this->addSql('ALTER TABLE desks DROP FOREIGN KEY FK_BFDA6542F6099FD1');
        $this->addSql('ALTER TABLE desks_options DROP FOREIGN KEY FK_37791DA46BD33809');
        $this->addSql('ALTER TABLE desks_options DROP FOREIGN KEY FK_37791DA43ADB05F1');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A6BD33809');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9FA6913E5');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE bookings');
        $this->addSql('DROP TABLE desks');
        $this->addSql('DROP TABLE desks_options');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE options');
        $this->addSql('DROP TABLE status_desks');
        $this->addSql('DROP TABLE status_users');
        $this->addSql('DROP TABLE users');
    }
}
