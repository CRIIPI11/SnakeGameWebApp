# Project Name: Simple Arcade

## Project Summary: This project will create a simple Arcade with scoreboards and competitions based on the implemented game.

## Github Link: https://github.com/CRIIPI11/IT202-005/tree/prod

## Project Board Link: https://github.com/CRIIPI11/IT202-005/projects/1

## Website Link: https://cdm9-prod.herokuapp.com/Project/

## Your Name: Cristhian Molina

<!--
### Line item / Feature template (use this for each bullet point)
#### Don't delete this

- [ ] \(mm/dd/yyyy of completion) Feature Title (from the proposal bullet point, if it's a sub-point indent it properly)
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
### End Line item / Feature Template
-->

### Proposal Checklist and Evidence

- Milestone 1

  - [x] \(10/09/2021) User will be able to register a new account

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/register.php
      - Pull Requests
        - PR link #1: https://github.com/CRIIPI11/IT202-005/pull/9
        - PR link #2: https://github.com/CRIIPI11/IT202-005/pull/20
        - PR link #3: https://github.com/CRIIPI11/IT202-005/pull/21
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140616903-2383062c-28e6-4de4-9cd6-89be5d00949b.png)
        - ![image](https://user-images.githubusercontent.com/60235905/140617004-c2bd4e77-e715-4eaf-b5fd-f86b2519ed22.png)
          - Screenshot #1 & #2 description: Here in the screenshots we can see the registration page, it has a form where it asks the users to input the crendentials they want to use for their accounts such as email, username, and password.
        - ![image](https://user-images.githubusercontent.com/60235905/140617014-17029465-7acc-4a5d-b8ca-69e2fab6d5c0.png)
          - Screenshot #3: After the users inputs their information, and given that their email is valid and their password matches, a new account will be created and a message will be displayed to confirmed it.

  - [x] \(10/09/2021) User will be able to login to their account (given they enter the correct credentials)

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/login.php
      - Pull Requests
        - PR link #1: https://github.com/CRIIPI11/IT202-005/pull/9
        - PR link #2: https://github.com/CRIIPI11/IT202-005/pull/20
        - PR link #3: https://github.com/CRIIPI11/IT202-005/pull/21
        - PR link #4: https://github.com/CRIIPI11/IT202-005/pull/23
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140617539-001af5ab-35f6-4d85-89af-19c77858f70a.png)
        - ![image](https://user-images.githubusercontent.com/60235905/140617550-b27fcd6a-8aae-48a5-bb4f-a305ffc62804.png)
        - ![image](https://user-images.githubusercontent.com/60235905/140617553-bac1c219-7dfd-442a-96ff-bb4e0b85168b.png)
        - ![image](https://user-images.githubusercontent.com/60235905/140617566-34920c1f-39cf-400f-9aa9-bbcfe0d43e60.png)
          - Screenshot descriptions: Here we can see the login page, the users will be ask to input their credentials to acces their account, they can either use their email or username and if it validates corretly, the users will enter their account.

  - [x] \(10/09/2021) User will be able to logout

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/logout.php
      - Pull Requests
        - PR link #1: https://github.com/CRIIPI11/IT202-005/pull/9
        - PR link #2: https://github.com/CRIIPI11/IT202-005/pull/20
        - PR link #3: https://github.com/CRIIPI11/IT202-005/pull/21
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140816847-91fc37b1-c8b3-410a-a1c0-a02d0e0b1ead.png)
          - Screenshot description: After the users logout, they will be redirected to the login page and a message will be display indicating that they have successfully logout.

  - [x] \(10/09/2021) Basic security rules implemented

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/login.php
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/21
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140618649-f31f9096-fe50-4699-a2fa-48afcfea4d5e.png)
          - Screenshot description: If the users tries to access a page that can't be access unless their logged in, they will be redirected to the login page and get an alert message saying so.

  - [x] \(10/09/2021) Basic Roles implemented

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/admin/list_roles.php
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/22
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140619161-e1bb1dc6-3d96-4909-925f-cf5bbaced68d.png)
          - Screenshot description: Here we can see the List Roles Page, this page as well as the other role pages will only be accessible for the users with an admin role. Here, the admin user will be able to see the list of current roles as well as their respective id, names and descriptions, the users will also be able to look for a specific role and either activate or desactivate any role.
        - ![image](https://user-images.githubusercontent.com/60235905/140619171-a76abbe6-bbb6-43e4-a803-4d72a3535281.png)
          - Screenshot description: Here we have the Create Roles Page, this page will allow the admin user to create a new role giving it a name and a description.
        - ![image](https://user-images.githubusercontent.com/60235905/140619190-7a2b2bfb-b307-4804-9fe4-6da0c379d643.png)
          - Screenshot description: Lastly we have the Assign Roles Page, here the admin user will be able to assign or remove current roles to any user.

  - [x] \(11/05/2021 ) Site should have basic styles/theme applied; everything should be styled

    - List of Evidence of Feature Completion
      - Status: Complete
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/styles.css
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/26
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140619906-580f6136-52ab-4476-b6fd-aa12e7cb9504.png)

  - [x] \(10/12/2021) Any output messages/errors should be “user friendly”

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/helpers.js
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/10
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140620371-45d3a99f-90e6-4d1a-b146-dfaa1c3a44d2.png)
        - ![image](https://user-images.githubusercontent.com/60235905/140620415-5fe69e54-a135-4c50-814c-0cf04f12b8d7.png)
        - ![image](https://user-images.githubusercontent.com/60235905/140618649-f31f9096-fe50-4699-a2fa-48afcfea4d5e.png)
        - ![image](https://user-images.githubusercontent.com/60235905/140617014-17029465-7acc-4a5d-b8ca-69e2fab6d5c0.png)
          - Screenshot descriptions: Here we can see that every message either an error, an alert, a success or info are outputed in their respective color and with a message becoming user friendly.

  - [x] \(10/18/2021) User will be able to see their profile

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/profile.php
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/10
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140620683-816970cf-639c-4350-8b96-9c6fb3625575.png)
          - Screenshot description: Here we have the Profile Page, the users will be able to see their current information such as email and username as well as having an option to update their password.

  - [x] \(10/18/2021) User will be able to edit their profile
    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/profile.php
      - Pull Requests
        - PR link #1: https://github.com/CRIIPI11/IT202-005/pull/10
        - PR link #2: https://github.com/CRIIPI11/IT202-005/pull/21
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/140620955-24bac2c5-6d81-4d32-9a28-3647165e0f5f.png)
          - Screenshot Description: If the users want, they will be able to edit their email or username, as well as update their current password if they provide their current password. If everything validates correctly, the credentials for the use will be updated.

- Milestone 2

  - [x] \(11/19/2021) Pick a simple game to implement, anything that generates a score that’s more advanced than a simple random number generator (may build off of a sample from the site shared in class)

    - List of Evidence of Feature Completion
      - Status: Partially working
      - What game will you be doing?
        - The game I will be doing for this project is a personalized version of the "Snake Game"
      - Briefly describe it
        - The concept of this game dates back to 1976 from an arcade game. The first version of the Snake Game as we know it first appeared in 1997 on the Nokia 6110 and since then, it has received different modifications either on the mechanincs or visual. For this project I'm bringing back this clasic including some modifications to it, giving it a more personalized touch.
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/Game/game.php
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/47
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/142943120-f772ada6-1a64-4b30-9d62-eaf499db6097.png))
          - Screenshot Description: This is the base game, currently the game is pretty basic in all aspects, it will receive further updates.  

  - [x] \(11/22/2021) The system will save the user’s score at the end of the game if the user is logged in

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/API/save_scores.php  https://cdm9-prod.herokuapp.com/Project/Game/game.php
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/48
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/143727510-144c9b5b-f41d-46f5-8977-a40e0b85bcd6.png)
          - Screenshot Description: After the game is over, we can see a successful message confirming the score has saved. 

  - [x] \(11/27/2021) The user will be able to see their last 10 scores

    - List of Evidence of Feature Completion
      - Status: Completed
      - Direct Link: https://cdm9-prod.herokuapp.com/Project/profile.php
      - Pull Requests
        - PR link #1: https://github.com/CRIIPI11/IT202-005/pull/49
        - PR link #2: https://github.com/CRIIPI11/IT202-005/pull/50
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/143728097-70d33f81-a5df-41f8-8822-8ff5ec24304c.png)
          - Screenshot Description: On the profile page, the user will be able to see a table showing scores. The table will show the last 10 scores by default but they will also have the chance to choose the amount from 5 to 20. 

  - [x] \(11/25/2021) Create functions that output the scoreboards 
    - List of Evidence of Feature Completion
      - Status: Completed
      - Pull Requests
        - PR link: https://github.com/CRIIPI11/IT202-005/pull/50 
      - Screenshots
        - ![image](https://user-images.githubusercontent.com/60235905/143728721-98c386d8-1bf4-45a9-9af2-8b9263730be5.png)
        - ![image](https://user-images.githubusercontent.com/60235905/143728915-42222d58-a9a2-4c51-8b25-8949f6b105e0.png)
          - Screenshot Description: Here we can see there are three different functions, each will be used separately to display the scoreboard for the past week, month, and lifetime.

- Milestone 3
- Milestone 4

### Intructions

#### Don't delete this

1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
7. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
8. Add, commit, push the related file changes to this branch
9. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
   - Screenshot(s) of the site view (make sure they clearly show the feature)
   - Screenshot of the database data if applicable
   - Describe each screenshot to specify exactly what's being shown
   - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
10. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)

    - Basically add an x to the checkbox markdown along with a date after
      - (i.e., - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel

11. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)

    - Merge the Milestone branch into dev, then dev into prod as needed
    - Last two steps are mostly for getting it to prod for delivery of the assignment

12. If the attached issues don't close wait until the next step
13. Merge the updated dev branch into your production branch via a pull request
14. Close any related issues that didn't auto close

    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board
