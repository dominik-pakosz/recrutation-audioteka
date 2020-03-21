<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200321060324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'create user table with example admin and user';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id VARCHAR(36) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO user VALUES (\'dd82db37-0599-48b9-ab2d-5f40f92a9958\', \'admin@gmail.com\', \'$2y$12$ihd5q.0/OoWc4prRM5x6YOCSKMVEMBpLpmdtjjEHvaZuW6ajcC8qu\', \'["ROLE_USER"]\');');
        $this->addSql('INSERT INTO user VALUES (\'e461bae1-72c5-4775-b86e-c673fb3458dd\', \'user@gmail.com\', \'$2y$12$ihd5q.0/OoWc4prRM5x6YOCSKMVEMBpLpmdtjjEHvaZuW6ajcC8qu\', \'["ROLE_USER","ROLE_ADMIN"]\');');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
    }
}
