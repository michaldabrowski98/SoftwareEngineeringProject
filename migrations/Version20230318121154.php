<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318121154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop column position from table user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP position');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD position INT NOT NULL');
    }
}
