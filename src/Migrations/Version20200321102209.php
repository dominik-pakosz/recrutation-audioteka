<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200321102209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add product table and few base product';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, created_by VARCHAR(36) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO product VALUES (\'4e9d6623-4933-46fe-8aa9-824bf3537ded\', \'The Godfather\', \'5999\', \'dd82db37-0599-48b9-ab2d-5f40f92a9958\');');
        $this->addSql('INSERT INTO product VALUES (\'f9eae9c9-a178-4f14-9d03-4b99516a663b\', \'Steve Jobs\', \'4995\', \'dd82db37-0599-48b9-ab2d-5f40f92a9958\');');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product');
    }
}
