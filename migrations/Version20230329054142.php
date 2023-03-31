<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230329054142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create foreign key to product';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shelf ADD CONSTRAINT FK_A5475BE34584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_A5475BE34584665A ON shelf (product_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shelf DROP FOREIGN KEY FK_A5475BE34584665A');
        $this->addSql('DROP INDEX IDX_A5475BE34584665A ON shelf');
    }
}
