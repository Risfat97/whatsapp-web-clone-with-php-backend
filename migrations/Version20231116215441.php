<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116215441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating table users';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable("users")) {
            $table = $schema->createTable("users");

            $table->addColumn("id", Types::INTEGER, [
                "unsigned" => true,
                "notnull" => true,
                "autoincrement" => true
            ]);

            $table->addColumn("firstname", Types::STRING, [
                "notnull" => true,
                "length" => 255
            ]);

            $table->addColumn("lastname", Types::STRING, [
                "notnull" => true,
                "length" => 255
            ]);

            $table->addColumn("username", Types::STRING, [
                "notnull" => true,
                "length" => 255
            ]);

            $table->addColumn("email", Types::STRING, [
                "notnull" => true,
                "length" => 255
            ]);

            $table->addColumn("password", Types::STRING, [
                "notnull" => true,
                "length" => 255
            ]);

            $table->addColumn("is_male", Types::BOOLEAN);

            $table->addColumn("birthday", Types::DATE_IMMUTABLE);

            $table->addColumn("is_online", Types::BOOLEAN);

            $table->addColumn("created_at", Types::DATETIME_IMMUTABLE);

            $table->setPrimaryKey(["id"]);
            $table->addUniqueIndex(["email"], 'UQ_email');
            $table->addUniqueIndex(["username"], 'UQ_username');
        }

    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable("users")) {
            $schema->dropTable("users");
        }
    }
}
