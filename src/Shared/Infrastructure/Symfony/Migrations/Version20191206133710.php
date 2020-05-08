<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191206133710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (user_id CHAR(36) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE UNIQUE INDEX user_email_uindex ON user (email);');
        $this->addSql('CREATE UNIQUE INDEX user_username_uindex ON user (username);');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX user_username_uindex');
        $this->addSql('DROP INDEX user_email_uindex');
        $this->addSql('DROP TABLE user');
    }
}
