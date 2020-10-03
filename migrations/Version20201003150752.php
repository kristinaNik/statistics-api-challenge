<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201003150752 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED93E2E969B');
        $this->addSql('DROP INDEX IDX_3535ED93E2E969B ON hotel');
        $this->addSql('ALTER TABLE hotel DROP review_id');
        $this->addSql('ALTER TABLE review ADD hotel_id INT NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C63243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('CREATE INDEX IDX_794381C63243BB18 ON review (hotel_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel ADD review_id INT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED93E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('CREATE INDEX IDX_3535ED93E2E969B ON hotel (review_id)');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C63243BB18');
        $this->addSql('DROP INDEX IDX_794381C63243BB18 ON review');
        $this->addSql('ALTER TABLE review DROP hotel_id');
    }
}
