<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs! This block will be used as the migration description if getDescription() is not used.
 */
class Version20160614111507 extends AbstractMigration
{

    /**
     * @return string
     */
    public function getDescription() {
        return '';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');

        $this->addSql('DROP INDEX uniq_57b9724f5e237e06 ON wegmeister_tagmanager_domain_model_group');
        $this->addSql('CREATE UNIQUE INDEX flow_identity_wegmeister_tagmanager_domain_model_group ON wegmeister_tagmanager_domain_model_group (name)');
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');

        $this->addSql('DROP INDEX flow_identity_wegmeister_tagmanager_domain_model_group ON wegmeister_tagmanager_domain_model_group');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57B9724F5E237E06 ON wegmeister_tagmanager_domain_model_group (name)');
    }
}