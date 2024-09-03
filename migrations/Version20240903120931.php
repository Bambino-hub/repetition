<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240903120931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matter ADD workspace_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matter ADD CONSTRAINT FK_B0DE9B6F82D40A1F FOREIGN KEY (workspace_id) REFERENCES work_space (id)');
        $this->addSql('CREATE INDEX IDX_B0DE9B6F82D40A1F ON matter (workspace_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matter DROP FOREIGN KEY FK_B0DE9B6F82D40A1F');
        $this->addSql('DROP INDEX IDX_B0DE9B6F82D40A1F ON matter');
        $this->addSql('ALTER TABLE matter DROP workspace_id');
    }
}
