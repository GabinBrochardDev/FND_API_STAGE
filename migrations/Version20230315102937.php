<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315102937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intership (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_student_id INTEGER NOT NULL, id_company_id INTEGER NOT NULL, sart_date DATE NOT NULL, end_date DATE NOT NULL, CONSTRAINT FK_CBD07C9E6E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBD07C9E32119A01 FOREIGN KEY (id_company_id) REFERENCES compagny (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CBD07C9E6E1ECFCD ON intership (id_student_id)');
        $this->addSql('CREATE INDEX IDX_CBD07C9E32119A01 ON intership (id_company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE intership');
    }
}
