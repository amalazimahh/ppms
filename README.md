# Project Progress Monitoring System (PPMS)
*A centralized web application developed for the Department of Development, Public Works Department (JKR)*

---

## Project Overview

PPMS is a custom-built Laravel web application developed as a Capstone Project at Universiti Teknologi Brunei (UTB). The system aims to improve project visibility, progress tracking, and decision-making for infrastructure projects under Brunei’s National Development Plan (RKN).

---

## Objectives

- Provide a centralized platform for project tracking and updates
- Implement real-time progress dashboards for ongoing projects
- Automate deadline and budget notifications
- Generate project reports summary in PDF
- Improve communication between stakeholders through system alerts

---

## Tech Stack

| Layer         | Technology                             |
|---------------|-----------------------------------------|
| Backend       | Laravel (PHP Framework)                |
| Frontend      | Blade Templating, HTML, Bootstrap5   |
| Database      | MySQL with Migrations & Seeders        |
| Charts        | Chart.js, ApexCharts                   |
| PDF Export    | DomPDF                                 |
| Scheduler     | Laravel Artisan Commands + Task Scheduling |
| Dev Server    | XAMPP (Local Development)              |

---

## Key Features

- **Authentication** with role-based access (Admin, Executive, Project Manager)  
- **Overall Dashboard** showing project stats, charts, and upcoming deadlines  
- **Project-Specific Dashboards** with progress breakdowns and summaries  
- **CRUD for Projects** with dynamic form sections  
- **Notifications & Alerts** (Deadlines, Overdue, Over Budget)  
- **Search & Filtering** for all project records  
- **Report Generation** (PDF format)

---

## Running the System Locally

1. **Clone the repository**
   ```bash
   git clone <your-repo-link>
   cd ppms

2. Install dependencies
    ```bash
    composer install
    npm install && npm run dev

3. Create .env and configure DB
    ```bash
    cp .env.example .env
    php artisan key:generate

4. Run the migrations and seeders
    ```bash
    php artisan migrate --seed

5. Start the local server
    ```bash
    php artisan serve

6. Schedule daily notification checks
    ```bash
    php artisan projects:check-statuses

## Development Timeline

- **System Design:** Jan–Feb 2025
- **System Development:** Feb–May 2025
- **Testing & UAT:** 19 June 2025
- **Final Report & Presentation:** June 2025

## Acknowledgements

- **Ms. Fatimah, UTB Supervisor** – for academic guidance and support
- **Mr. Nizam, Host Supervisor (DoD JKR)** – for insights into departmental workflows
- **DoD JKR Staff** – for their cooperation during system requirement analysis
- **Universiti Teknologi Brunei** – for the academic platform and guidance

## Licenses
- This project was developed as part of a university capstone project. Not licensed for commercial use.
