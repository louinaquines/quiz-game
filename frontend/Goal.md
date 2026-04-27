To make this project clear for an AI agent (like Cursor, Claude Code, or Kilo AI), your `goal.md` needs to define the **boundaries** between the two folders and the **communication protocol** (how they talk to each other).

Copy and paste this into your `goal.md`:

---

# Project Goal: AI-Powered Quiz Game (Decoupled Laravel Architecture)

## 🎯 Overview
Build a real-time, AI-driven quiz platform where teachers create rooms, AI generates questions via OpenRouter, and students compete in real-time. The project is **non-monolithic**, split into two distinct Laravel applications within one root directory.

## 🏗️ Directory Structure
- `/backend`: Laravel 11 API (Business logic, Database, WebSockets, AI orchestration).
- `/frontend`: Laravel 11 + Livewire (UI/UX, Real-time listeners via Echo).

---

## 🛠️ Technical Stack & Constraints
- **Backend Framework:** Laravel 11 (API Mode).
- **Frontend Framework:** Laravel 11 + Livewire + Alpine.js + Tailwind CSS.
- **Real-time:** Laravel Reverb (WebSocket server).
- **AI:** OpenRouter API (Model: Claude-3 or GPT-4o) for JSON question generation.
- **Data:** PostgreSQL (Primary), Redis (Leaderboards & Live State).
- **Communication:** Frontend consumes Backend via REST API & WebSockets. **No shared database connections.**

---

## 🚦 End-to-End Game Flow (Agent Instructions)
1. **Room Creation:** Teacher creates a room (6-digit code). Backend stores `room` with `status: pending`.
2. **Joining:** Students join via code. Backend creates `participant` record and broadcasts `UserJoined` event.
3. **AI Generation:** Teacher submits a topic. Backend calls OpenRouter, parses JSON, and populates `questions` table.
4. **Active Quiz:** - Backend broadcasts `QuestionStarted` with a timestamp.
   - Frontend listeners trigger a CSS-based countdown.
   - Scoring Logic: `(Correct * 1000) + (remaining_ms * bonus_multiplier)`.
5. **Leaderboard:** Post-quiz, the system displays the Top 10 participants ranked by cumulative score.

---

## 🗄️ Database Schema Reference
- **users:** `id, email, password, role (teacher|student)`.
- **rooms:** `id, code, teacher_id, topic, status (waiting|active|finished)`.
- **participants:** `id, room_id, user_id, nickname, score, streak`.
- **questions:** `id, room_id, text, choices (jsonb), correct_index, order_num`.
- **answers:** `id, participant_id, question_id, is_correct, responded_at_ms`.

---

## 🔧 Setup & Commands for Agent
### Backend (`/backend`)
```bash
composer install
php artisan install:api
php artisan install:broadcasting # Select Reverb
php artisan migrate
php artisan reverb:start
```

### Frontend (`/frontend`)
```bash
composer install
npm install && npm run dev
# Configure .env:
# LARAVEL_ECHO_HOST=localhost
# LARAVEL_ECHO_PORT=8080
# API_URL=http://localhost:8000
```

---

## 🛑 Critical Logic Notes
- **Server Authority:** The timer and "next question" triggers must come from the Backend (Reverb). The Frontend must never decide when a question ends.
- **Statelessness:** The Frontend uses Laravel Sanctum tokens to authenticate requests to the Backend.
- **Response Format:** OpenRouter prompts must strictly enforce a JSON schema to prevent backend parsing errors.