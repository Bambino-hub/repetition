<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002092920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE days (id INT AUTO_INCREMENT NOT NULL, workspace_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_EBE4FC6682D40A1F (workspace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email_verify (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, time INT DEFAULT NULL, code INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matter (id INT AUTO_INCREMENT NOT NULL, workspace_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B0DE9B6F82D40A1F (workspace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, matter JSON NOT NULL COMMENT \'(DC2Type:json)\', days JSON NOT NULL COMMENT \'(DC2Type:json)\', time_table JSON NOT NULL COMMENT \'(DC2Type:json)\', level VARCHAR(255) NOT NULL, INDEX IDX_3DDCB9FFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_table (id INT AUTO_INCREMENT NOT NULL, workspace_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B35B6E3A82D40A1F (workspace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', telephone VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_FIRSTNAME (firstname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_space (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, level_id INT DEFAULT NULL, INDEX IDX_189BA15A76ED395 (user_id), INDEX IDX_189BA155FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE days ADD CONSTRAINT FK_EBE4FC6682D40A1F FOREIGN KEY (workspace_id) REFERENCES work_space (id)');
        $this->addSql('ALTER TABLE matter ADD CONSTRAINT FK_B0DE9B6F82D40A1F FOREIGN KEY (workspace_id) REFERENCES work_space (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE time_table ADD CONSTRAINT FK_B35B6E3A82D40A1F FOREIGN KEY (workspace_id) REFERENCES work_space (id)');
        $this->addSql('ALTER TABLE work_space ADD CONSTRAINT FK_189BA15A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE work_space ADD CONSTRAINT FK_189BA155FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE days DROP FOREIGN KEY FK_EBE4FC6682D40A1F');
        $this->addSql('ALTER TABLE matter DROP FOREIGN KEY FK_B0DE9B6F82D40A1F');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFA76ED395');
        $this->addSql('ALTER TABLE time_table DROP FOREIGN KEY FK_B35B6E3A82D40A1F');
        $this->addSql('ALTER TABLE work_space DROP FOREIGN KEY FK_189BA15A76ED395');
        $this->addSql('ALTER TABLE work_space DROP FOREIGN KEY FK_189BA155FB14BA7');
        $this->addSql('DROP TABLE days');
        $this->addSql('DROP TABLE email_verify');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE matter');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE time_table');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work_space');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
