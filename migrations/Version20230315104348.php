<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315104348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__intership AS SELECT id, id_student_id, id_company_id, sart_date, end_date FROM intership');
        $this->addSql('DROP TABLE intership');
        $this->addSql('CREATE TABLE intership (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_student_id INTEGER NOT NULL, id_company_id INTEGER NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, CONSTRAINT FK_CBD07C9E6E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBD07C9E32119A01 FOREIGN KEY (id_company_id) REFERENCES compagny (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO intership (id, id_student_id, id_company_id, start_date, end_date) SELECT id, id_student_id, id_company_id, sart_date, end_date FROM __temp__intership');
        $this->addSql('DROP TABLE __temp__intership');
        $this->addSql('CREATE INDEX IDX_CBD07C9E32119A01 ON intership (id_company_id)');
        $this->addSql('CREATE INDEX IDX_CBD07C9E6E1ECFCD ON intership (id_student_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__intership AS SELECT id, id_student_id, id_company_id, start_date, end_date FROM intership');
        $this->addSql('DROP TABLE intership');
        $this->addSql('CREATE TABLE intership (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_student_id INTEGER NOT NULL, id_company_id INTEGER NOT NULL, sart_date DATE NOT NULL, end_date DATE NOT NULL, CONSTRAINT FK_CBD07C9E6E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBD07C9E32119A01 FOREIGN KEY (id_company_id) REFERENCES compagny (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO intership (id, id_student_id, id_company_id, sart_date, end_date) SELECT id, id_student_id, id_company_id, start_date, end_date FROM __temp__intership');
        $this->addSql('DROP TABLE __temp__intership');
        $this->addSql('CREATE INDEX IDX_CBD07C9E6E1ECFCD ON intership (id_student_id)');
        $this->addSql('CREATE INDEX IDX_CBD07C9E32119A01 ON intership (id_company_id)');
    }
}
