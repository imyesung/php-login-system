# PHP Login System

This is a simple PHP login system built using XAMPP.

## Features
- User registration
- User login
- Session management
- Logout functionality
- Basic security measures

## Installation
1. Clone the repository to your `htdocs` directory.
2. Start XAMPP and make sure Apache and MySQL are running.
3. Create a MySQL database and import the provided SQL script.
4. Edit `config.php` with your database credentials.
5. Access the project in your browser at `http://localhost/php-login`.

## Usage
- Navigate to the registration page to create a new user.
- Log in with your credentials to access the dashboard.

--- 

### 프로젝트 목표:  
PHP로 안전한 로그인 시스템을 구축하여, 사용자의 인증과 세션 관리를 학습하고 구현합니다. 이 과정에서 보안적 측면을 고려한 코드 작성과 테스트를 병행합니다.

### 주요 기능:
1. 사용자 등록 (회원가입)
2. 사용자 로그인
3. 세션 관리 (로그인 상태 유지)
4. 로그아웃 기능
5. 보안 강화 (입력 데이터 검증, 패스워드 해싱, SQL 인젝션 방지)
6. 추가 기능: 비밀번호 재설정, 로그인 시도 제한, 2단계 인증(선택 사항)

## 구현 계획 (블럭 단위)

### 블럭 1: 개발 환경 설정
- **목표**: MacBook M2에서 PHP 개발 환경을 설정하고 GitHub에 프로젝트 리포지토리를 생성합니다.
- **내용**:
  - PHP와 Composer 설치
  - 프로젝트 폴더 생성 및 초기화
  - `README.md` 작성
  - `.gitignore` 설정 (`vendor/`, `.env` 파일 제외)
  - GitHub 리포지토리 생성 및 연결
- **완료 조건**: GitHub에 프로젝트가 푸시되고, 기본적인 폴더 구조가 설정됨.

### 블럭 2: 데이터베이스 설정 및 연결
- **목표**: MySQL 데이터베이스를 설정하고, PHP와 연결합니다.
- **내용**:
  - MySQL 설치 및 데이터베이스 생성 (`php_login`)
  - `users` 테이블 생성 (필드: `id`, `username`, `email`, `password`, `created_at`)
  - PHP와 MySQL 연결 설정 (`config.php` 파일 작성)
- **완료 조건**: PHP에서 MySQL 데이터베이스와의 연결이 성공적으로 이루어짐.

### 블럭 3: 사용자 등록 기능 구현
- **목표**: 사용자가 회원가입할 수 있는 기능을 구현합니다.
- **내용**:
  - `register.php` 파일 작성
  - 사용자의 입력 데이터 검증 (유효성 검사)
  - 비밀번호 해싱 후 데이터베이스에 저장
  - 성공 또는 실패 메시지 출력
- **완료 조건**: 회원가입이 성공적으로 이루어지고, 데이터베이스에 사용자 정보가 저장됨.

### 블럭 4: 사용자 로그인 기능 구현
- **목표**: 사용자가 로그인할 수 있는 기능을 구현합니다.
- **내용**:
  - `index.php` 파일 작성
  - 로그인 폼 구현
  - 입력된 비밀번호와 해시된 비밀번호 비교 (`password_verify` 사용)
  - 성공 시 세션 생성 및 대시보드로 리다이렉트
- **완료 조건**: 사용자가 로그인할 수 있고, 세션이 생성됨.

### 블럭 5: 세션 관리 및 로그아웃 기능 구현
- **목표**: 로그인 상태를 유지하고, 로그아웃 기능을 구현합니다.
- **내용**:
  - `session.php` 파일 작성 (세션 체크 및 리다이렉트 기능)
  - `logout.php` 파일 작성 (세션 종료 및 로그인 페이지로 리다이렉트)
  - 대시보드 페이지 (`dashboard.php`) 작성
- **완료 조건**: 사용자가 로그인 상태를 유지하고, 로그아웃 시 세션이 종료됨.

### 블럭 6: 보안 강화
- **목표**: 로그인 시스템에 보안 강화 요소를 추가합니다.
- **내용**:
  - SQL 인젝션 방지 (Prepared Statements 사용)
  - XSS 방지 (입력 데이터 출력 시 `htmlspecialchars` 사용)
  - HTTPS 사용 권장 (필요시 로컬 개발 환경에서 SSL 설정)
- **완료 조건**: 보안 취약점에 대한 기본적인 방어가 완료됨.

### 블럭 7: 추가 기능 (선택 사항)
- **목표**: 프로젝트에 추가적인 보안 기능을 구현합니다.
- **내용**:
  - 비밀번호 재설정 기능 구현 (이메일 발송)
  - 로그인 시도 횟수 제한 기능 (무차별 대입 공격 방지)
  - 2단계 인증(2FA) 구현
- **완료 조건**: 추가 기능이 성공적으로 구현되고 테스트됨.

## GitHub 리포지토리 구조
```
php-login-system/
│
├── README.md           # 프로젝트 개요 및 설명
├── .gitignore          # Git에서 제외할 파일 목록
├── config.php          # 데이터베이스 설정 파일
├── register.php        # 회원가입 페이지
├── index.php           # 로그인 페이지
├── dashboard.php       # 대시보드 페이지
├── logout.php          # 로그아웃 처리 페이지
├── session.php         # 세션 관리 파일
└── assets/             # CSS, JS 등 프론트엔드 파일
```
## Git Workflow

- Main Branch: main (모든 기능이 병합되는 최종 브랜치)
- Feature Branches: 각 블럭에 대한 작업은 별도의 기능 브랜치에서 진행 (feature/block-name)
- Pull Requests (PR): 기능 구현 후 main 브랜치로 병합할 때 PR을 통해 코드 리뷰 진행. PR은 코드 변경 내역을 문서화하고, 협업자들이 리뷰.
- Commit Messages: 모든 커밋 메시지는 명확하고 간결하게 작성
  - eg. Implement user registration functionality
  - Fix typo in README.md
- Merging: PR 리뷰 및 승인 후, main 브랜치에 병합. 병합 시 squash and merge 이를 통해 하나의 커밋으로 기록 정리

