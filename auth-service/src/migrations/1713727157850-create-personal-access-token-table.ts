import { MigrationInterface, QueryRunner } from "typeorm";

export class CreatePersonalAccessTokenTable1713727157850
    implements MigrationInterface
{
    public async up(queryRunner: QueryRunner): Promise<void> {
        queryRunner.query(`CREATE TABLE personal_access_tokens (
            id varchar(36) NOT NULL,
            identity json NOT NULL,
            accessToken varchar(625) NOT NULL,
            refreshToken varchar(625) NOT NULL,
            ipAddress varchar(255) DEFAULT NULL,
            revoked tinyint NOT NULL DEFAULT '0',
            createdAt datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
            updatedAt datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
            PRIMARY KEY (id)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci`);
    }

    public async down(queryRunner: QueryRunner): Promise<void> {
        queryRunner.query(`DROP TABLE personal_access_tokens`);
    }
}
