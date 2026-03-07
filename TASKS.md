# TASKS

Things to do. DO NOT USE LLM TO GENERATE CODE.

## Reorder Later

- Make it able to change the LaTeX rendering engine
- Make it also be able to use the local LaTeX renderer like TeXLive
- quicktex, upmath.me, mathjax, local, disable render, implement it
- same change and disable PlantUML
- Do fractional indexing for blocks of text
- Add Redis to store info on what is being written for collaboratoin
- sotre snapshots on db postgresql json something
- Send the current changes on the other collaborators. Not directly change what
  is on the database
- Websocket connection for collaboration
- Blocks of sections instead of one file of information being sent on editor.
- Look at RBAC Database Schema Design (not this one)
- See access control list (ACL could be good here)

---

## Workflow

### TODO

1. Database
    - [ ] Fix/Create Database Schema
    - [ ] Redesign the concept for sharing vaults (do not if proved to be good)
    - [ ] Fix APIs

2. Vaults
    - [ ] Bind Contibuted Vaults to database (will be clarified soon)

3. Editor
    - [ ] Create notes in database
    - [ ] Read notes from database
    - [ ] Update notes from database
    - [ ] Delete notes from database
    - [ ] Image embedding and storage on server (use local for now)
    - [ ] Syntax Highlighting
    - [ ] Create File Tree or folder-like setup in File explorer
    - [ ] Efficiently handle merge conflicts on multiple account changes when
    editing a similar file
    - [ ] Undo Redo
    - [ ] Add helpful buttons on top of the editor
    - [ ] Revamp the UI for the Split, Preview, and Edit
    - [ ] Show the coordinate of the vertical bar. Put it in the bottom
    - [ ] Add some other helper things on the bottom. (... put something here)
    - [ ] Permission read and write for the current Vault
    - [ ] Permission read and write for individual page on the folder
    - [ ] Fix Mobile UI

4. Parser
    - [ ] Be able to parse UML code
    - [ ] Fix Markdown parser (needs expansion)
    - [ ] Menu for settings (include a chage for LaTeX parser like MathJAX if no
    access to upmath.me)

5. Own LaTeX rendering server
    - [ ] Remove support from upmath.me and create your own server for this.

6. No login required editor

### IN-PROGRESS

1. Database
2. Vaults
3. Editor
4. Parser

### TEST (Create several test cases)

1. Database
2. Vaults
3. Editor
4. Parser

### DONE

1. Database
2. Vaults
3. Editor
4. Parser

---

## Overall Planned Features

1. Login/SignUp user account system
2. Markdown + $\LaTeX$ editor
3. Markdown + $\LaTeX$ previewer
4. File-tree for Current Notes in the Notebook
5. Notebook sharing for collaborative editing

### v0.2.0 Features

- [x] Responsive design for mobile users
- [x] Account system
- [x] Developed profile page
- [x] Vault creation for storing related files
- [x] Remember sessions for each user
- [x] Auto-pairing for brackets, parenthesis, and other delimiters

### v0.1.0 Features

- [x] `<textarea>` field for editing
- [x] `<previewer>` field for rendering parsed Markdown text
- [x] `<previewer>` update on `<textarea>` input
- [x] Scroll synchronization on `<textarea>` and `<previewer>`
- [x] Markdown parser
- [x] $\LaTeX$ parser

### Future Development

- [ ] UML Diagram
- [ ] Syntax highlighting on editor
- [ ] Vault sharing for collaborative editing
- [ ] File-tree for Current Notes in the Vault
- [ ] Notes vault sharing for collaborative editing
