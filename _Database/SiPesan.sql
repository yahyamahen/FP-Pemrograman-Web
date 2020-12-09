/*==============================================================*/
/* Table: MAHASISWA                                             */
/*==============================================================*/
create or replace table MAHASISWA 
(
   NPM                  char(20)       primary key     not null,
   PASSWORD             char(25)                       null,
   NAMA_MHS             varchar(50)                    not null,
   EMAIL                varchar(50)                    null,
   JURUSAN              varchar(50)                    null,
   SEMESTER             integer                        null
);


/*==============================================================*/
/* Table: SURAT                                                 */
/*==============================================================*/
create or replace table SURAT 
(
   ID_SURAT             char(20)       primary key     not null,
   NPM                  char(20)                       null,
   NO_SURAT             char(30)                       null,
   KATEGORI             varchar(50)                    not null,
   JUDUL_SURAT          varchar(50)                    not null,
   PERUSAHAAN           varchar(50)                    not null,
   PERIHAL_LENGKAP      integer                        not null,
);

alter table SURAT
      add foreign key (NPM) references MAHASISWA (NPM);

