DROP DATABASE IF EXISTS mydb;

CREATE DATABASE mydb;

USE mydb;
CREATE TABLE Types (
    types_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255)
);

CREATE TABLE Statuses (
    statuses_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(255)
);

CREATE TABLE Priorities (
    priorities_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    priority VARCHAR(255)
);

CREATE TABLE Tasks (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    task_datetime DATETIME NOT NULL,
    type_id INT(11),
    status_id INT(11),
    priority_id INT(11),
    description TEXT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES Types(types_id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES Statuses(statuses_id) ON DELETE CASCADE,
    FOREIGN KEY (priority_id) REFERENCES Priorities(priorities_id) ON DELETE CASCADE
);

INSERT INTO Types (type)
VALUES ("Feature"),
       ("Bug");

INSERT INTO Priorities (priority)
VALUES ("Low"),
       ("Medium"),
       ("High"),
       ("Critical");

INSERT INTO Statuses (status)
VALUES ("To Do"),
       ("In Progress"),
       ("Done");

INSERT INTO Tasks (title, task_datetime, type_id, status_id, priority_id, description)
VALUES
		("Keep all the updated requirements in one place", "2022-10-08", 1, 1, 3, "There is hardly anything more frustrating than having to look for current requirements in tens of comments under the actual description or having to decide which commenter is actually authorized to change the requirements. The goal here is to keep all the up-to-date requirements and details in the main/primary description of a task. Even though the information in comments may affect initial criteria, just update this primary description accordingly."),
		("Consider creating an acceptance criteria list", "2022-10-08", 1, 1, 3, "Descriptive requirements are very helpful when it comes to understanding the context of a problem, yet finally it is good to precisely specify what is expected. Thus the developer will not have to look for the actual requirements in a long, descriptive text but he will be able to easily get to the essence. One might find that sometimes — when acceptance criteria are well defined — there is little or no need for any additional information. Example:
        a) User navigates to “/accounts” and clicks on red download CSV button
        b) Popup appears with two buttons: “This year” and “Last year”
        c) If user clicked on “Last year” download is initiated
        d) CSV downloaded includes following columns…"),
		("Provide mockups", "2022-10-08", 1, 1, 3, "A textual requirements description is essential in most cases, but an image is often worth more than a thousand words. Even a simple mockup can limit misunderstandings by a great factor. There are many apps out there that might be helpful here, like Balsamiq, InVision or Mockingbird, but manipulating screenshots of an existing app also works."),
		("Provide examples, credentials, etc", "2022-10-08", 1, 1, 3, "If the expectation is to process or generate some file — attach an example of such a file. If the goal is to integrate what is being developed with some service, ensure your devs have access to this service and its documentation. This list could go on and on — the bottom line is — if there is something that our developer might make use of, try to foresee it and provide them with (access to) it."),
		("Use charts and diagrams", "2022-10-08", 1, 1, 3, "While it is not always necessary, sometimes it might be beneficial to prepare a flowchart, a block diagram or some other kind of concept visualization that will render it easy for the developer to comprehend the task and its scope."),
		("Spoil your developers with details", "2022-10-08", 1, 1, 3, "It is always safer to assume less rather than more domain knowledge in the dev team. Therefore following the KISS principle and augmenting each description or acceptance criteria list with contextual/domain knowledge and details that might become relevant is highly recommended."),
		("Describe edge cases and provide constraints", "2022-10-08", 1, 2, 3, "Hardly any developer likes constraints, but if there are some, let them be communicated early. Do we need to support some specific browsers? Does this script need to run below a specific amount of time? Is it crucial for this endpoint to respond in no more than n milliseconds? If there are some such concerns, make sure they are included in your descriptions. Also describing any edge cases might be beneficial. Maybe we have some query limit on a given service? If you have such knowledge it is always beneficial for your devs to know about it upfront."),
		("Provide a copy", "2022-10-08", 1, 2, 3, "If there is a long message to be displayed, just provide a copy for it somewhere in the description. Do not place it on mockups as it is always slower and more error-prone to re-type it than to copy-paste it."),
		("Describe steps to reproduce an issue", "2022-10-08", 2, 2, 3, "including as many details as possible."),
		("Provide access", "2022-10-08", 2, 2, 3, "to the affected account and services if possible. It might be hard to reproduce the exact environment on a local machine."),
		("Provide environment information", "2022-10-08", 2, 2, 3, "i.e., browser version, operating system version etc. Sometimes a list of installed browser plugins and extensions might be helpful as well."),
		("Provide a link to an exception and/or a stack trace", "2022-10-08", 2, 2, 3, "as investigating those is usually the first step to take in resolving the problem."),
		("Provide access to logs", "2022-10-08", 2, 3, 3, "as they can be helpful in reproducing the steps that caused the problem in the first place."),
		("Make a screencast", "2022-10-08", 2, 3, 3, "It is not always necessary, but many times a short screencast (or at least a screenshot) says more than a thousand words. While working on MacOS you can use QuickTime Player for the purpose but there are plenty of tools available for other operating systems as well."),
		("Provide contact information", "2022-10-08", 2, 3, 3, "of the person that reported the bug. This will not always be possible, but in some cases it might be advantageous and most effective if a developer can have a chat with a person that actually experienced the bug, especially if the steps to reproduce a problem are not deterministic."),
		("Annotate", "2022-10-08", 1, 3, 3, "The mockup provided can sometimes be confusing for developers. Especially if it contains much more content than the scope of the task described. Drop a couple of arrows, outlines and annotations here and there to emphasize what are the important parts of the mockup from the task requirements perspective.");
