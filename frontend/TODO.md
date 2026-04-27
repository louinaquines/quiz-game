# Quiz Game Implementation TODO

## Backend
- [ ] Fix `create_rooms_table` migration (duplicate `$table->id()`)
- [ ] Create `questions` migration
- [ ] Create `answers` migration
- [ ] Update `Room` model (fillables, relationships)
- [ ] Update `Participant` model (fillables, relationships)
- [ ] Create `Question` model
- [ ] Create `Answer` model
- [ ] Update `AuthController` (add login with Sanctum)
- [ ] Create `OpenRouterService`
- [ ] Update `RoomController` (create, join, generateQuestions, startQuiz, submitAnswer, leaderboard)
- [ ] Update `routes/api.php`
- [ ] Create Events (`UserJoined`, `QuestionStarted`, `AnswerSubmitted`, `QuizEnded`)
- [ ] Configure broadcasting/Reverb

## Frontend
- [ ] Add Livewire to `composer.json`
- [ ] Create `login.blade.php`
- [ ] Create `teacher/dashboard.blade.php`
- [ ] Create `student/lobby.blade.php`
- [ ] Create `quiz.blade.php`
- [ ] Create `leaderboard.blade.php`
- [ ] Update `routes/web.php`
- [ ] Update `resources/js/app.js` for Echo/Reverb

## Setup & Testing
- [ ] Run migrations
- [ ] Install dependencies
- [ ] Start servers

