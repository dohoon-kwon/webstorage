# 창의적종합설계1
리눅스 서버 기반 웹 데이터 스토리지 프로젝트

## 1. 환경
1. MariaDB

2. Apache

3. PHP

##  2.라이브러리
1. php-gd

2. jquery

3. ffmpeg = https://toshi15shkim.github.io/articles/2019-09/etc-ffmpeg-install

## 3.DB

### 회원db

```sql
create table USERINFO (
id varchar(15) primary key,
pw varchar (30) not null,
tel varchar(15) not null,
name varchar(30) not null,
grade varchar(30) not null default 'basic' );
```

### 파일저장DB

```sql
CREATE TABLE DATAINFO (
FILE_NAME VARCHAR(30),
FILE_ORIGIN_NAME VARCHAR(30) NOT NULL,
FILE_EXTENSION VARCHAR(10) NOT NULL,
FILE_SIZE BIGINT NOT NULL,
FILE_PATH VARCHAR(255) NOT NULL,
FILE_USER_ID VARCHAR(30) NOT NULL,
FILE_THUM_PATH VARCHAR(255),
PRIMARY KEY(FILE_NAME),
FOREIGN KEY (FILE_USER_ID) REFERENCES USERINFO(id)
)
ENGINE = InnoDB;
```

### 파일공유 그룹 DB


```sql
create table SHAREINFO (
SHARE_CODE VARCHAR(30) primary key,
SHARE_NAME VARCHAR(30) not null,
SHARE_USERS VARCHAR(255) not null );
```

### 알림창 DB


```sql
create table MSGINFO (
MSG_NUM int primary key,
MSG_TIME datetime not null,
MSG_REC_USER varchar(30) not null,
MSG_SEND_USER varchar(30) not null,
MSG_CONTENT varchar(255) not null,
MSG_SHARE_CODE VARCHAR(255) not null,
READ_BOOL tinyint(1) not null );

ALTER TABLE MSGINFO MODIFY MSG_NUM int  AUTO_INCREMENT;
ALTER TABLE MSGINFO AUTO_INCREMENT=1;
```

### 휴지통 DB


```sql
CREATE TABLE TRASHINFO (
FILE_NAME VARCHAR(30),
FILE_ORIGIN_NAME VARCHAR(30) NOT NULL,
FILE_EXTENSION VARCHAR(10) NOT NULL,
FILE_SIZE BIGINT NOT NULL,
FILE_PATH VARCHAR(50) NOT NULL,
FILE_USER_ID VARCHAR(30) NOT NULL,
FILE_THUM_PATH VARCHAR(255),
PRIMARY KEY(FILE_NAME),
FOREIGN KEY (FILE_USER_ID) REFERENCES USERINFO(id)
);
```

##  4. 기능
- 로그인 페이지
    - 1 로그인 기능
    - 2 회원 가입

- 마이페이지(제작 예정)
    - 1 자신의 정보 조회
    - 2 자신 정보 수정

- 저장소 페이지
    - 1 파일 업로드 및 다운로드
    - 2 파일 드래그 드롭
    - 3 파일 종류별 보기
    - 4 휴지통 (파일 임시 보관 및 복원, 영구삭제 기능)
    - 5 새로운 디렉토리 생성
    - 6 정렬 방식 선택기능

- 공유 폴더(수정 예정)
    - 1 공유 폴더 생성 기능
    - 2 유저 초대 기능
    - 3 초대받은 공유 폴더 알림 기능


- 홈페이지 유저 정보 관리(관리자 이상 사용가능)(수정 예정)
    - 1 유저 정보 조회 및 수정
    - 2 유저 탈퇴 처리 기능
