<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329101149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE desks DROP FOREIGN KEY FK_BFDA654267B3B43D');
        $this->addSql('DROP INDEX IDX_BFDA654267B3B43D ON desks');
        $this->addSql('ALTER TABLE desks CHANGE users_id owners_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE desks ADD CONSTRAINT FK_BFDA6542236ECBFC FOREIGN KEY (owners_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_BFDA6542236ECBFC ON desks (owners_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE desks DROP FOREIGN KEY FK_BFDA6542236ECBFC');
        $this->addSql('DROP INDEX IDX_BFDA6542236ECBFC ON desks');
        $this->addSql('ALTER TABLE desks CHANGE owners_id users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE desks ADD CONSTRAINT FK_BFDA654267B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_BFDA654267B3B43D ON desks (users_id)');
    }
}
