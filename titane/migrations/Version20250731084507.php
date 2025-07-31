<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250731084507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, project_id BIGINT UNSIGNED NOT NULL, author_id BIGINT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, seo_description VARCHAR(160) DEFAULT NULL, og_image VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, status VARCHAR(20) NOT NULL, is_deleted TINYINT(1) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, published_at DATETIME DEFAULT NULL, INDEX IDX_23A0E66166D1F9C (project_id), INDEX IDX_23A0E66F675F31B (author_id), UNIQUE INDEX UNIQ_PROJECT_SLUG (project_id, slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_tags (article_id BIGINT UNSIGNED NOT NULL, tag_id BIGINT UNSIGNED NOT NULL, INDEX IDX_DFFE13277294869C (article_id), INDEX IDX_DFFE1327BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_version (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, article_id BIGINT UNSIGNED NOT NULL, author_id BIGINT UNSIGNED NOT NULL, version_number INT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, seo_description VARCHAR(160) DEFAULT NULL, og_image VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_52CE97747294869C (article_id), INDEX IDX_52CE9774F675F31B (author_id), UNIQUE INDEX UNIQ_ARTICLE_VERSION (article_id, version_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, project_id BIGINT UNSIGNED NOT NULL, internal_name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5288FD4F166D1F9C (project_id), UNIQUE INDEX UNIQ_PROJECT_SLUG (project_id, slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_field (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, form_id BIGINT UNSIGNED NOT NULL, field_id VARCHAR(50) NOT NULL, label VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, field_type VARCHAR(20) NOT NULL, field_order INT UNSIGNED NOT NULL, container_class VARCHAR(255) DEFAULT NULL, label_class VARCHAR(255) DEFAULT NULL, field_class VARCHAR(255) DEFAULT NULL, is_mandatory TINYINT(1) NOT NULL, default_value VARCHAR(255) DEFAULT NULL, options JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, INDEX IDX_D8B2E19B5FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jwt_blacklist (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, user_id BIGINT UNSIGNED NOT NULL, jti VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B0F0291EC53CF2EA (jti), INDEX IDX_B0F0291EA76ED395 (user_id), INDEX IDX_EXPIRES_AT (expires_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, project_id BIGINT UNSIGNED NOT NULL, uploaded_by_id BIGINT UNSIGNED NOT NULL, filename VARCHAR(255) NOT NULL, file_path VARCHAR(500) NOT NULL, file_type VARCHAR(10) NOT NULL, mime_type VARCHAR(100) NOT NULL, file_size INT UNSIGNED NOT NULL, alt_text VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_6A2CA10C166D1F9C (project_id), INDEX IDX_6A2CA10CA2B28FE8 (uploaded_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_tags (media_id BIGINT UNSIGNED NOT NULL, tag_id BIGINT UNSIGNED NOT NULL, INDEX IDX_ACFB4BF5EA9FDD75 (media_id), INDEX IDX_ACFB4BF5BAD26311 (tag_id), PRIMARY KEY(media_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, project_id BIGINT UNSIGNED NOT NULL, author_id BIGINT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, seo_description VARCHAR(160) DEFAULT NULL, og_image VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, status VARCHAR(20) NOT NULL, is_deleted TINYINT(1) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, published_at DATETIME DEFAULT NULL, INDEX IDX_140AB620166D1F9C (project_id), INDEX IDX_140AB620F675F31B (author_id), UNIQUE INDEX UNIQ_PROJECT_SLUG (project_id, slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_version (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, page_id BIGINT UNSIGNED NOT NULL, author_id BIGINT UNSIGNED NOT NULL, version_number INT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, seo_description VARCHAR(160) DEFAULT NULL, og_image VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_457C3856C4663E4 (page_id), INDEX IDX_457C3856F675F31B (author_id), UNIQUE INDEX UNIQ_PAGE_VERSION (page_id, version_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE password_reset_token (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, user_id BIGINT UNSIGNED NOT NULL, token_uid VARCHAR(36) NOT NULL, expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, used_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_6B7BA4B68AB3BB5A (token_uid), INDEX IDX_6B7BA4B6A76ED395 (user_id), INDEX IDX_EXPIRES_AT (expires_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, created_by_id BIGINT UNSIGNED NOT NULL, uid VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, is_archived TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_2FB3D0EE539B0606 (uid), INDEX IDX_2FB3D0EEB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, form_id BIGINT UNSIGNED NOT NULL, form_slug VARCHAR(255) NOT NULL, submission_data JSON NOT NULL COMMENT \'(DC2Type:json)\', ip_address VARCHAR(45) DEFAULT NULL, user_agent LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_A3C664D35FF69B7D (form_id), INDEX IDX_FORM_SLUG (form_slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, project_id BIGINT UNSIGNED NOT NULL, parent_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_389B783166D1F9C (project_id), INDEX IDX_389B783727ACA70 (parent_id), UNIQUE INDEX UNIQ_PROJECT_SLUG (project_id, slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, uid VARCHAR(36) NOT NULL, email VARCHAR(255) NOT NULL, salt VARCHAR(8) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, pen_name VARCHAR(100) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_UID (uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_project_role (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, user_id BIGINT UNSIGNED NOT NULL, project_id BIGINT UNSIGNED NOT NULL, role VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_EE343E70A76ED395 (user_id), INDEX IDX_EE343E70166D1F9C (project_id), UNIQUE INDEX UNIQ_USER_PROJECT (user_id, project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE article_tags ADD CONSTRAINT FK_DFFE13277294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_tags ADD CONSTRAINT FK_DFFE1327BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_version ADD CONSTRAINT FK_52CE97747294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_version ADD CONSTRAINT FK_52CE9774F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE form_field ADD CONSTRAINT FK_D8B2E19B5FF69B7D FOREIGN KEY (form_id) REFERENCES form (id)');
        $this->addSql('ALTER TABLE jwt_blacklist ADD CONSTRAINT FK_B0F0291EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE media_tags ADD CONSTRAINT FK_ACFB4BF5EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_tags ADD CONSTRAINT FK_ACFB4BF5BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE page_version ADD CONSTRAINT FK_457C3856C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_version ADD CONSTRAINT FK_457C3856F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE password_reset_token ADD CONSTRAINT FK_6B7BA4B6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D35FF69B7D FOREIGN KEY (form_id) REFERENCES form (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783727ACA70 FOREIGN KEY (parent_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE user_project_role ADD CONSTRAINT FK_EE343E70A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_project_role ADD CONSTRAINT FK_EE343E70166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66166D1F9C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE article_tags DROP FOREIGN KEY FK_DFFE13277294869C');
        $this->addSql('ALTER TABLE article_tags DROP FOREIGN KEY FK_DFFE1327BAD26311');
        $this->addSql('ALTER TABLE article_version DROP FOREIGN KEY FK_52CE97747294869C');
        $this->addSql('ALTER TABLE article_version DROP FOREIGN KEY FK_52CE9774F675F31B');
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4F166D1F9C');
        $this->addSql('ALTER TABLE form_field DROP FOREIGN KEY FK_D8B2E19B5FF69B7D');
        $this->addSql('ALTER TABLE jwt_blacklist DROP FOREIGN KEY FK_B0F0291EA76ED395');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C166D1F9C');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA2B28FE8');
        $this->addSql('ALTER TABLE media_tags DROP FOREIGN KEY FK_ACFB4BF5EA9FDD75');
        $this->addSql('ALTER TABLE media_tags DROP FOREIGN KEY FK_ACFB4BF5BAD26311');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620166D1F9C');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620F675F31B');
        $this->addSql('ALTER TABLE page_version DROP FOREIGN KEY FK_457C3856C4663E4');
        $this->addSql('ALTER TABLE page_version DROP FOREIGN KEY FK_457C3856F675F31B');
        $this->addSql('ALTER TABLE password_reset_token DROP FOREIGN KEY FK_6B7BA4B6A76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB03A8386');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D35FF69B7D');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783166D1F9C');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783727ACA70');
        $this->addSql('ALTER TABLE user_project_role DROP FOREIGN KEY FK_EE343E70A76ED395');
        $this->addSql('ALTER TABLE user_project_role DROP FOREIGN KEY FK_EE343E70166D1F9C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_tags');
        $this->addSql('DROP TABLE article_version');
        $this->addSql('DROP TABLE form');
        $this->addSql('DROP TABLE form_field');
        $this->addSql('DROP TABLE jwt_blacklist');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_tags');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_version');
        $this->addSql('DROP TABLE password_reset_token');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_project_role');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
