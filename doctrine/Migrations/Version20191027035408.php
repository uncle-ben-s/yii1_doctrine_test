<?php

namespace doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191027035408 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE doctrine_history_types (
          id INT AUTO_INCREMENT NOT NULL, 
          name VARCHAR(50) NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_histories (
          id INT AUTO_INCREMENT NOT NULL, 
          type_id INT DEFAULT NULL, 
          card_id INT DEFAULT NULL, 
          user_id INT DEFAULT NULL, 
          create_date DATETIME NOT NULL, 
          info VARCHAR(255) NOT NULL, 
          INDEX IDX_A1D61780C54C8C93 (type_id), 
          INDEX IDX_A1D617804ACC9A20 (card_id), 
          INDEX IDX_A1D61780A76ED395 (user_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          doctrine_histories 
        ADD 
          CONSTRAINT FK_A1D61780C54C8C93 FOREIGN KEY (type_id) REFERENCES doctrine_history_types (id)');
        $this->addSql('ALTER TABLE 
          doctrine_histories 
        ADD 
          CONSTRAINT FK_A1D617804ACC9A20 FOREIGN KEY (card_id) REFERENCES doctrine_cards (id)');
        $this->addSql('ALTER TABLE 
          doctrine_histories 
        ADD 
          CONSTRAINT FK_A1D61780A76ED395 FOREIGN KEY (user_id) REFERENCES doctrine_user (id)');
        $this->addSql('ALTER TABLE doctrine_cards CHANGE status status VARCHAR(6) DEFAULT \'close\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doctrine_histories DROP FOREIGN KEY FK_A1D61780C54C8C93');
        $this->addSql('DROP TABLE doctrine_history_types');
        $this->addSql('DROP TABLE doctrine_histories');
        $this->addSql('ALTER TABLE 
          doctrine_cards CHANGE status status VARCHAR(6) DEFAULT \'close\' NOT NULL COLLATE utf8_unicode_ci');
    }
}
