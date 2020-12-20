/*==============================================================*/
/* Table: MAHASISWA                                             */
/*==============================================================*/
CREATE OR REPLACE TABLE mahasiswa 
(
   npm                  CHAR(20)       PRIMARY KEY     NOT NULL,
   pass             	CHAR(25)                       NULL,
   nama_mhs             VARCHAR(50)                    NOT NULL,
   email                VARCHAR(50)                    NULL,
   jurusan              VARCHAR(50)                    NULL,
   semester             INTEGER                        NULL
);


/*==============================================================*/
/* Table: SURAT                                                 */
/*==============================================================*/
CREATE OR REPLACE TABLE surat 
(
   id_surat             CHAR(20)       PRIMARY KEY     NOT NULL,
   npm                  CHAR(20)                       NULL,
   no_surat             CHAR(30)                       NULL,
   kategori             VARCHAR(50)                    NOT NULL,
   judul_surat          VARCHAR(50)                    NOT NULL,
   perusahaan           VARCHAR(50)                    NOT NULL,
   perihal_lengkap      INTEGER                        NOT NULL
);

ALTER TABLE surat
      ADD FOREIGN KEY (npm) REFERENCES mahasiswa (npm);

