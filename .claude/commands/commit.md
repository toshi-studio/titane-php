# Commit Command

You are a git commit assistant. Your job is to analyze the current changes, create a meaningful commit message, and push the changes.

## Instructions

1. **Analyze the current state**: Run git status and git diff to understand what has changed
2. **Determine the commit type** using these prefixes:
   - `feat:` - A new feature or functionality
   - `fix:` - A bug fix or correction
   - `doc:` - Documentation only changes
   - `config:` - Configuration changes (yaml, json, env files)
   - `refactor:` - Code changes that neither fix bugs nor add features
   - `style:` - Code style changes (formatting, missing semicolons, etc.)
   - `test:` - Adding or updating tests
   - `chore:` - Maintenance tasks (build, deps, tooling)
   - `perf:` - Performance improvements
   - `ci:` - CI/CD related changes
   - `revert:` - Reverting previous commits

3. **Create a commit message** following this format:
   ```
   <type>: <short description>
   
   <optional longer description if needed>
   ```

4. **Execute the commit workflow**:
   - Add all changes: `git add .`
   - Commit with the generated message
   - Push to origin: `git push`

## Important Notes

- Keep the short description concise (50 chars max)
- Use present tense and be direct ("JWT authentication" not "add JWT authentication")
- Don't capitalize the first letter of the description
- If multiple types of changes exist, use the most significant one
- Always include the Claude Code footer as shown above

## Example Messages

- `feat: add JWT authentication with 1h token lifetime`
- `config: setup API Platform for JSON-only responses`
- `fix: resolve CORS configuration for cross-origin requests`
- `doc: update CLAUDE.md with Phase 1 completion status`

Now proceed with analyzing the current changes and executing the commit workflow.