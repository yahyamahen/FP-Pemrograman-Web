/*==============================================================*/
/* Table: MAHASISWA                                             */
/*==============================================================*/
CREATE OR REPLACE TABLE mahasiswa 
(
   npm                  CHAR(20)       PRIMARY KEY   NOT NULL,
   pass             	VARCHAR(255)                     NOT NULL,
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
   id_surat             CHAR(20)       PRIMARY KEY    	NOT NULL,
   npm                  CHAR(20)                       	NOT NULL,
   no_surat             CHAR(30)                       	NOT NULL,
   kategori             VARCHAR(50)                    	NOT NULL,
   judul_surat          VARCHAR(50)                    	NOT NULL,
   perusahaan           VARCHAR(50)                    	NULL,
   perihal_lengkap      INTEGER                        	NULL
);

ALTER TABLE surat
      ADD FOREIGN KEY (npm) REFERENCES mahasiswa (npm);
      
SELECT * FROM mahasiswa;
DELETE FROM mahasiswa npm = 123;