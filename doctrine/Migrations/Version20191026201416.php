<?php

namespace doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191026201416 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE doctrine_transactions (
          id INT AUTO_INCREMENT NOT NULL, 
          card_id INT DEFAULT NULL, 
          amount INT NOT NULL, 
          create_date DATETIME NOT NULL, 
          type_name VARCHAR(10) NOT NULL, 
          INDEX IDX_255329A64ACC9A20 (card_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          doctrine_transactions 
        ADD 
          CONSTRAINT FK_255329A64ACC9A20 FOREIGN KEY (card_id) REFERENCES doctrine_cards (id)');
        $this->addSql('ALTER TABLE doctrine_cards CHANGE status status VARCHAR(6) DEFAULT \'close\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE doctrine_transactions');
        $this->addSql('ALTER TABLE 
          doctrine_cards CHANGE status status VARCHAR(6) DEFAULT \'close\' NOT NULL COLLATE utf8_unicode_ci');
    }
}
