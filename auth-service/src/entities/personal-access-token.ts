import {
    Column,
    CreateDateColumn,
    Entity,
    PrimaryGeneratedColumn,
    UpdateDateColumn,
} from "typeorm";

@Entity("personal_access_tokens")
class PersonalAccessToken {
    @PrimaryGeneratedColumn("uuid")
    id: string;

    @Column({ type: "json" })
    identity: string;

    @Column({ length: 625 })
    accessToken: string;

    @Column({ length: 625 })
    refreshToken: string;

    @Column({ nullable: true })
    ipAddress: string;

    @Column({ type: "boolean", default: false })
    revoked: boolean;

    @CreateDateColumn()
    createdAt: Date;

    @UpdateDateColumn()
    updatedAt: Date;
}

export default PersonalAccessToken;
