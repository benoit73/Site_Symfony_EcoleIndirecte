<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222132259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, eleve_id INT NOT NULL, cour_id INT NOT NULL, justifiee TINYINT(1) NOT NULL, INDEX IDX_765AE0C9A6CC7B2 (eleve_id), INDEX IDX_765AE0C9B7942F03 (cour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendrier (id INT AUTO_INCREMENT NOT NULL, annee INT NOT NULL, mois INT NOT NULL, jour INT NOT NULL, semaine INT NOT NULL, date INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nom_classe VARCHAR(255) NOT NULL, niveau VARCHAR(255) DEFAULT NULL, nb_eleves INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cour (id INT AUTO_INCREMENT NOT NULL, enseignant_matiere_classe_id INT NOT NULL, duree INT NOT NULL, jour INT NOT NULL, semaine INT NOT NULL, debut INT NOT NULL, annee INT NOT NULL, INDEX IDX_A71F964F33ECEC1F (enseignant_matiere_classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, parents_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, nom_eleve VARCHAR(255) NOT NULL, prenom_eleve VARCHAR(255) NOT NULL, mail_eleve VARCHAR(255) DEFAULT NULL, date_naissance VARCHAR(255) DEFAULT NULL, INDEX IDX_ECA105F7B706B6D3 (parents_id), INDEX IDX_ECA105F78F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, nom_enseignant VARCHAR(255) NOT NULL, prenom_enseignant VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant_matiere (enseignant_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_33D1A024E455FCC0 (enseignant_id), INDEX IDX_33D1A024F46CD258 (matiere_id), PRIMARY KEY(enseignant_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant_matiere_classe (id INT AUTO_INCREMENT NOT NULL, enseignant_id INT NOT NULL, matiere_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_25155D2E455FCC0 (enseignant_id), INDEX IDX_25155D2F46CD258 (matiere_id), INDEX IDX_25155D28F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom_matiere VARCHAR(255) NOT NULL, nb_enseignants INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parents (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, parents_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A6CC7B2 (eleve_id), UNIQUE INDEX UNIQ_8D93D649B706B6D3 (parents_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F33ECEC1F FOREIGN KEY (enseignant_matiere_classe_id) REFERENCES enseignant_matiere_classe (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7B706B6D3 FOREIGN KEY (parents_id) REFERENCES parents (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE enseignant_matiere ADD CONSTRAINT FK_33D1A024E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignant_matiere ADD CONSTRAINT FK_33D1A024F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignant_matiere_classe ADD CONSTRAINT FK_25155D2E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE enseignant_matiere_classe ADD CONSTRAINT FK_25155D2F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE enseignant_matiere_classe ADD CONSTRAINT FK_25155D28F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649B706B6D3 FOREIGN KEY (parents_id) REFERENCES parents (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9A6CC7B2');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9B7942F03');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F33ECEC1F');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7B706B6D3');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F78F5EA509');
        $this->addSql('ALTER TABLE enseignant_matiere DROP FOREIGN KEY FK_33D1A024E455FCC0');
        $this->addSql('ALTER TABLE enseignant_matiere DROP FOREIGN KEY FK_33D1A024F46CD258');
        $this->addSql('ALTER TABLE enseignant_matiere_classe DROP FOREIGN KEY FK_25155D2E455FCC0');
        $this->addSql('ALTER TABLE enseignant_matiere_classe DROP FOREIGN KEY FK_25155D2F46CD258');
        $this->addSql('ALTER TABLE enseignant_matiere_classe DROP FOREIGN KEY FK_25155D28F5EA509');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649A6CC7B2');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649B706B6D3');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE calendrier');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cour');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE enseignant_matiere');
        $this->addSql('DROP TABLE enseignant_matiere_classe');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE parents');
        $this->addSql('DROP TABLE `user`');
    }
}
