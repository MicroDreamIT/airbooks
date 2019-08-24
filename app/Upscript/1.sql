ALTER TABLE airbook.ab_points DROP COLUMN sub_text;
ALTER TABLE airbook.ab_points ADD COLUMN points_type ENUM('aircraft','apu','engine','part','wanted');
ALTER TABLE airbook.ab_points ADD COLUMN number_points INTEGER DEFAULT 0;
ALTER TABLE airbook.ab_points ADD COLUMN point_text TEXT DEFAULT NULL ;


ALTER TABLE airbook.ab_aircrafts CHANGE offer_for offer_for ENUM('Sale', 'ACMI', 'Dry Lease', 'Wet Lease', 'Exchange','Charter','Lease Purchase') DEFAULT NULL;
ALTER TABLE airbook.ab_engines CHANGE offer_for offer_for ENUM('Sale','Lease','Exchange','Lease Purchase') DEFAULT NULL;
ALTER TABLE airbook.ab_apus CHANGE offer_for offer_for ENUM('Sale','Lease','Exchange','Lease Purchase') DEFAULT NULL;


ALTER TABLE airbook.ab_leads DROP FOREIGN KEY leads_type_id_foreign ;
ALTER TABLE airbook.ab_leads DROP COLUMN type_id;
ALTER TABLE airbook.ab_leads DROP COLUMN entity_id;

ALTER TABLE airbook.ab_leads ADD COLUMN leadable_id INTEGER;
ALTER TABLE airbook.ab_leads ADD COLUMN leadable_type VARCHAR(255);

ALTER TABLE airbook.ab_leads ADD COLUMN message TEXT NULL;



ALTER TABLE airbook.ab_leads DROP FOREIGN KEY leads_company_id_foreign;
ALTER TABLE airbook.ab_leads DROP COLUMN company_id;

ALTER TABLE airbook.ab_leads DROP COLUMN lead_staus;
ALTER TABLE airbook.ab_leads ADD COLUMN lead_status ENUM('Read','Unread');

ALTER TABLE airbook.ab_seos ADD COLUMN method VARCHAR(250);

ALTER TABLE airbook.ab_leads ADD COLUMN creator_id INTEGER;

ALTER TABLE airbook.ab_contacts DROP FOREIGN KEY contacts_user_id_foreign;
ALTER TABLE airbook.ab_contacts DROP COLUMN user_id;
ALTER TABLE airbook.ab_contacts ADD COLUMN email VARCHAR(255);
ALTER TABLE airbook.ab_contacts MODIFY COLUMN is_public BOOLEAN DEFAULT 1;


ALTER TABLE airbook.ab_users ADD COLUMN transaction_id VARCHAR(255) NULL;
ALTER TABLE airbook.ab_users ADD COLUMN order_id VARCHAR(255) NULL;
ALTER TABLE airbook.ab_users ADD COLUMN trans_date TIMESTAMP NULL;

