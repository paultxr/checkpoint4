<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203082510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_activated TINYINT(1) NOT NULL, INDEX IDX_9067F23C156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, url LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_16DB4F89CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, is_available TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_techno (user_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_5CD5F5E1A76ED395 (user_id), INDEX IDX_5CD5F5E151F3C1BC (techno_id), PRIMARY KEY(user_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C156BE243 FOREIGN KEY (recruiter_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89CCFA12B8 FOREIGN KEY (profile_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE user_techno ADD CONSTRAINT FK_5CD5F5E1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_techno ADD CONSTRAINT FK_5CD5F5E151F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649BE04EA9');
        $this->addSql('ALTER TABLE user_techno DROP FOREIGN KEY FK_5CD5F5E151F3C1BC');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C156BE243');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89CCFA12B8');
        $this->addSql('ALTER TABLE user_techno DROP FOREIGN KEY FK_5CD5F5E1A76ED395');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE techno');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_techno');
    }
}
