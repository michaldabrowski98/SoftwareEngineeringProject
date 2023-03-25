<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230325132735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create shelf entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shelf (id INT AUTO_INCREMENT NOT NULL, alley INT NOT NULL, level INT NOT NULL, col INT NOT NULL, max_weight DOUBLE PRECISION NOT NULL, quantity INT DEFAULT NULL, product_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE shelf');
    }
}
