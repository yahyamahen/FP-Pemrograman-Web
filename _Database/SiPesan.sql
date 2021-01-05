/*==============================================================*/
/* Table: USER                                             */
/*==============================================================*/
CREATE TABLE USER( 
   id          INT               PRIMARY KEY       NOT NULL         AUTO_INCREMENT, 
   username    VARCHAR(50), 
   PASSWORD    VARCHAR(255)
);


/*==============================================================*/
/* Table: MAHASISWA                                             */
/*==============================================================*/
CREATE OR REPLACE TABLE mahasiswa 
(
   npm                  CHAR(20)       PRIMARY KEY   	NOT NULL,
   pass             	VARCHAR(255)                    NOT NULL,
   nama_mhs             VARCHAR(50)                    	NOT NULL,
   email                VARCHAR(50)                    	NULL,
   jurusan              VARCHAR(50)                    	NULL,
   semester             INTEGER                        	NULL,
   foto_profil 		VARCHAR(50)			NULL
);


/*==============================================================*/
/* Table: SURAT                                                 */
/*==============================================================*/
CREATE OR REPLACE TABLE surat 
(
   id 			INT 		PRIMARY KEY 	NOT NULL  AUTO_INCREMENT,		
   npm                  CHAR(20)                       	NOT NULL,
   no_surat             CHAR(30)                       	NOT NULL,
   kategori             VARCHAR(50)                    	NOT NULL,
   judul_surat          VARCHAR(255)                    NOT NULL,
   perusahaan           VARCHAR(255)                    NOT NULL,
   perihal_lengkap      VARCHAR(1024)                   NOT NULL,
   status_surat		VARCHAR(255)			NULL
);

ALTER TABLE surat
      ADD FOREIGN KEY (npm) REFERENCES mahasiswa (npm);
      
