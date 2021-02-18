<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218124251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469C872EC465');
        $this->addSql('DROP INDEX IDX_649B469C872EC465 ON statistic');
        $this->addSql('ALTER TABLE statistic CHANGE beer_id_id beer_id INT NOT NULL');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CD0989053 FOREIGN KEY (beer_id) REFERENCES beer (id)');
        $this->addSql('CREATE INDEX IDX_649B469CD0989053 ON statistic (beer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CD0989053');
        $this->addSql('DROP INDEX IDX_649B469CD0989053 ON statistic');
        $this->addSql('ALTER TABLE statistic CHANGE beer_id beer_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469C872EC465 FOREIGN KEY (beer_id_id) REFERENCES beer (id)');
        $this->addSql('CREATE INDEX IDX_649B469C872EC465 ON statistic (beer_id_id)');
    }
}
