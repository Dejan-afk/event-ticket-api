<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260317142209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_list DROP CONSTRAINT fk_9e5ea13b6c1197c9');
        $this->addSql('DROP INDEX idx_9e5ea13b6c1197c9');
        $this->addSql('ALTER TABLE board_list RENAME COLUMN project_id_id TO project_id');
        $this->addSql('ALTER TABLE board_list ADD CONSTRAINT FK_9E5EA13B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_9E5EA13B166D1F9C ON board_list (project_id)');
        $this->addSql('ALTER TABLE project_member DROP CONSTRAINT fk_674011329d86650f');
        $this->addSql('ALTER TABLE project_member DROP CONSTRAINT fk_674011326c1197c9');
        $this->addSql('DROP INDEX idx_674011329d86650f');
        $this->addSql('DROP INDEX idx_674011326c1197c9');
        $this->addSql('ALTER TABLE project_member ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_member ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_member DROP user_id_id');
        $this->addSql('ALTER TABLE project_member DROP project_id_id');
        $this->addSql('ALTER TABLE project_member ADD CONSTRAINT FK_67401132A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE project_member ADD CONSTRAINT FK_67401132166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_67401132A76ED395 ON project_member (user_id)');
        $this->addSql('CREATE INDEX IDX_67401132166D1F9C ON project_member (project_id)');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb256c1197c9');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb25ad9dee8');
        $this->addSql('DROP INDEX idx_527edb256c1197c9');
        $this->addSql('DROP INDEX idx_527edb25ad9dee8');
        $this->addSql('ALTER TABLE task ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD board_list_id INT NOT NULL');
        $this->addSql('ALTER TABLE task DROP project_id_id');
        $this->addSql('ALTER TABLE task DROP board_list_id_id');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2575B03E84 FOREIGN KEY (board_list_id) REFERENCES board_list (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_527EDB25166D1F9C ON task (project_id)');
        $this->addSql('CREATE INDEX IDX_527EDB2575B03E84 ON task (board_list_id)');
        $this->addSql('ALTER TABLE task_assignment DROP CONSTRAINT fk_2cd60f15b8e08577');
        $this->addSql('ALTER TABLE task_assignment DROP CONSTRAINT fk_2cd60f159d86650f');
        $this->addSql('DROP INDEX idx_2cd60f15b8e08577');
        $this->addSql('DROP INDEX idx_2cd60f159d86650f');
        $this->addSql('ALTER TABLE task_assignment ADD task_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_assignment ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_assignment DROP task_id_id');
        $this->addSql('ALTER TABLE task_assignment DROP user_id_id');
        $this->addSql('ALTER TABLE task_assignment ADD CONSTRAINT FK_2CD60F158DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE task_assignment ADD CONSTRAINT FK_2CD60F15A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_2CD60F158DB60186 ON task_assignment (task_id)');
        $this->addSql('CREATE INDEX IDX_2CD60F15A76ED395 ON task_assignment (user_id)');
        $this->addSql('ALTER TABLE task_comment DROP CONSTRAINT fk_8b957886b8e08577');
        $this->addSql('ALTER TABLE task_comment DROP CONSTRAINT fk_8b9578869d86650f');
        $this->addSql('DROP INDEX idx_8b957886b8e08577');
        $this->addSql('DROP INDEX idx_8b9578869d86650f');
        $this->addSql('ALTER TABLE task_comment ADD task_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_comment ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_comment DROP task_id_id');
        $this->addSql('ALTER TABLE task_comment DROP user_id_id');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B9578868DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B957886A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_8B9578868DB60186 ON task_comment (task_id)');
        $this->addSql('CREATE INDEX IDX_8B957886A76ED395 ON task_comment (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_list DROP CONSTRAINT FK_9E5EA13B166D1F9C');
        $this->addSql('DROP INDEX IDX_9E5EA13B166D1F9C');
        $this->addSql('ALTER TABLE board_list RENAME COLUMN project_id TO project_id_id');
        $this->addSql('ALTER TABLE board_list ADD CONSTRAINT fk_9e5ea13b6c1197c9 FOREIGN KEY (project_id_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9e5ea13b6c1197c9 ON board_list (project_id_id)');
        $this->addSql('ALTER TABLE project_member DROP CONSTRAINT FK_67401132A76ED395');
        $this->addSql('ALTER TABLE project_member DROP CONSTRAINT FK_67401132166D1F9C');
        $this->addSql('DROP INDEX IDX_67401132A76ED395');
        $this->addSql('DROP INDEX IDX_67401132166D1F9C');
        $this->addSql('ALTER TABLE project_member ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_member ADD project_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_member DROP user_id');
        $this->addSql('ALTER TABLE project_member DROP project_id');
        $this->addSql('ALTER TABLE project_member ADD CONSTRAINT fk_674011329d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_member ADD CONSTRAINT fk_674011326c1197c9 FOREIGN KEY (project_id_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_674011329d86650f ON project_member (user_id_id)');
        $this->addSql('CREATE INDEX idx_674011326c1197c9 ON project_member (project_id_id)');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB2575B03E84');
        $this->addSql('DROP INDEX IDX_527EDB25166D1F9C');
        $this->addSql('DROP INDEX IDX_527EDB2575B03E84');
        $this->addSql('ALTER TABLE task ADD project_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD board_list_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task DROP project_id');
        $this->addSql('ALTER TABLE task DROP board_list_id');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT fk_527edb256c1197c9 FOREIGN KEY (project_id_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT fk_527edb25ad9dee8 FOREIGN KEY (board_list_id_id) REFERENCES board_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_527edb256c1197c9 ON task (project_id_id)');
        $this->addSql('CREATE INDEX idx_527edb25ad9dee8 ON task (board_list_id_id)');
        $this->addSql('ALTER TABLE task_assignment DROP CONSTRAINT FK_2CD60F158DB60186');
        $this->addSql('ALTER TABLE task_assignment DROP CONSTRAINT FK_2CD60F15A76ED395');
        $this->addSql('DROP INDEX IDX_2CD60F158DB60186');
        $this->addSql('DROP INDEX IDX_2CD60F15A76ED395');
        $this->addSql('ALTER TABLE task_assignment ADD task_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_assignment ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_assignment DROP task_id');
        $this->addSql('ALTER TABLE task_assignment DROP user_id');
        $this->addSql('ALTER TABLE task_assignment ADD CONSTRAINT fk_2cd60f15b8e08577 FOREIGN KEY (task_id_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_assignment ADD CONSTRAINT fk_2cd60f159d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2cd60f15b8e08577 ON task_assignment (task_id_id)');
        $this->addSql('CREATE INDEX idx_2cd60f159d86650f ON task_assignment (user_id_id)');
        $this->addSql('ALTER TABLE task_comment DROP CONSTRAINT FK_8B9578868DB60186');
        $this->addSql('ALTER TABLE task_comment DROP CONSTRAINT FK_8B957886A76ED395');
        $this->addSql('DROP INDEX IDX_8B9578868DB60186');
        $this->addSql('DROP INDEX IDX_8B957886A76ED395');
        $this->addSql('ALTER TABLE task_comment ADD task_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_comment ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_comment DROP task_id');
        $this->addSql('ALTER TABLE task_comment DROP user_id');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT fk_8b957886b8e08577 FOREIGN KEY (task_id_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT fk_8b9578869d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8b957886b8e08577 ON task_comment (task_id_id)');
        $this->addSql('CREATE INDEX idx_8b9578869d86650f ON task_comment (user_id_id)');
    }
}
