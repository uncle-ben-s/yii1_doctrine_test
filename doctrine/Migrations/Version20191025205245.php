<?php

namespace doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191025205245 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE doctrine_currency (
          id INT AUTO_INCREMENT NOT NULL, 
          name VARCHAR(150) NOT NULL, 
          code VARCHAR(3) NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_filter_types (
          id INT AUTO_INCREMENT NOT NULL, 
          name VARCHAR(150) NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_user (
          id INT AUTO_INCREMENT NOT NULL, 
          role_id INT DEFAULT NULL, 
          email VARCHAR(80) NOT NULL, 
          pass_hash VARCHAR(255) NOT NULL, 
          UNIQUE INDEX UNIQ_29B97835E7927C74 (email), 
          INDEX IDX_29B97835D60322AC (role_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_role (
          id INT AUTO_INCREMENT NOT NULL, 
          name VARCHAR(10) NOT NULL, 
          UNIQUE INDEX UNIQ_F34324165E237E06 (name), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_prices (
          id INT AUTO_INCREMENT NOT NULL, 
          currency_id INT DEFAULT NULL, 
          value INT NOT NULL, 
          INDEX IDX_562F716638248176 (currency_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_cards (
          id INT AUTO_INCREMENT NOT NULL, 
          price_id INT DEFAULT NULL, 
          create_date DATETIME NOT NULL, 
          name VARCHAR(255) NOT NULL, 
          status VARCHAR(6) DEFAULT \'close\' NOT NULL, 
          UNIQUE INDEX UNIQ_5DD54F44D614C7E7 (price_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_cards_filters (
          card_id INT NOT NULL, 
          filter_id INT NOT NULL, 
          INDEX IDX_91DBC9914ACC9A20 (card_id), 
          INDEX IDX_91DBC991D395B25E (filter_id), 
          PRIMARY KEY(card_id, filter_id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctrine_filters (
          id INT AUTO_INCREMENT NOT NULL, 
          type_id INT DEFAULT NULL, 
          value VARCHAR(150) NOT NULL, 
          INDEX IDX_CEA3AEACC54C8C93 (type_id), 
          UNIQUE INDEX filter_type_filter_idx (type_id, value), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          doctrine_user 
        ADD 
          CONSTRAINT FK_29B97835D60322AC FOREIGN KEY (role_id) REFERENCES doctrine_role (id)');
        $this->addSql('ALTER TABLE 
          doctrine_prices 
        ADD 
          CONSTRAINT FK_562F716638248176 FOREIGN KEY (currency_id) REFERENCES doctrine_currency (id)');
        $this->addSql('ALTER TABLE 
          doctrine_cards 
        ADD 
          CONSTRAINT FK_5DD54F44D614C7E7 FOREIGN KEY (price_id) REFERENCES doctrine_prices (id)');
        $this->addSql('ALTER TABLE 
          doctrine_cards_filters 
        ADD 
          CONSTRAINT FK_91DBC9914ACC9A20 FOREIGN KEY (card_id) REFERENCES doctrine_cards (id)');
        $this->addSql('ALTER TABLE 
          doctrine_cards_filters 
        ADD 
          CONSTRAINT FK_91DBC991D395B25E FOREIGN KEY (filter_id) REFERENCES doctrine_filters (id)');
        $this->addSql('ALTER TABLE 
          doctrine_filters 
        ADD 
          CONSTRAINT FK_CEA3AEACC54C8C93 FOREIGN KEY (type_id) REFERENCES doctrine_filter_types (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doctrine_prices DROP FOREIGN KEY FK_562F716638248176');
        $this->addSql('ALTER TABLE doctrine_filters DROP FOREIGN KEY FK_CEA3AEACC54C8C93');
        $this->addSql('ALTER TABLE doctrine_user DROP FOREIGN KEY FK_29B97835D60322AC');
        $this->addSql('ALTER TABLE doctrine_cards DROP FOREIGN KEY FK_5DD54F44D614C7E7');
        $this->addSql('ALTER TABLE doctrine_cards_filters DROP FOREIGN KEY FK_91DBC9914ACC9A20');
        $this->addSql('ALTER TABLE doctrine_cards_filters DROP FOREIGN KEY FK_91DBC991D395B25E');
        $this->addSql('DROP TABLE doctrine_currency');
        $this->addSql('DROP TABLE doctrine_filter_types');
        $this->addSql('DROP TABLE doctrine_user');
        $this->addSql('DROP TABLE doctrine_role');
        $this->addSql('DROP TABLE doctrine_prices');
        $this->addSql('DROP TABLE doctrine_cards');
        $this->addSql('DROP TABLE doctrine_cards_filters');
        $this->addSql('DROP TABLE doctrine_filters');
    }
}
