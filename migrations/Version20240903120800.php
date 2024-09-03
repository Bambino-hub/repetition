<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240903120800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE days ADD workspace_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE days ADD CONSTRAINT FK_EBE4FC6682D40A1F FOREIGN KEY (workspace_id) REFERENCES work_space (id)');
        $this->addSql('CREATE INDEX IDX_EBE4FC6682D40A1F ON days (workspace_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE days DROP FOREIGN KEY FK_EBE4FC6682D40A1F');
        $this->addSql('DROP INDEX IDX_EBE4FC6682D40A1F ON days');
        $this->addSql('ALTER TABLE days DROP workspace_id');
    }
}
