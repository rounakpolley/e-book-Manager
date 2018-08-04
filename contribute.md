If this is your first time using git then make a copy of the project directory just in case..

### Get your copy
`git clone https://github.com/rounakpolley/e-book-Manager.git`

or use ssh
`git clone git@github.com:rounakpolley/e-book-Manager.git`

or download zip

### Check your project status
`git status` you should get something like or with a list of untracked and modified files
```
On branch feature
nothing to commit, working directory clean
```
Also check the remote - you should get the exact same output with `https://github.com/rounakpolley/` if you are using https
`git remote -v`
```
origin	git@github.com:rounakpolley/Ebook_Manager.git (fetch)
origin	git@github.com:rounakpolley/Ebook_Manager.git (push)
```
If you get not a git project then...

### Initalize git VCS and add remote
`git init`

Followed by
`git remote add origin https://github.com/rounakpolley/e-book-Manager.git`

or if you are using ssh

`git remote add git@github.com:rounakpolley/e-book-Manager.git`

If you did a different output for `git remote -v` then also  you need to follow the `git remote add`

### Create a branch
First see the existing branches
`git branch`
```
  cataloge-note
* feature
  features
  master
  phpmod
```
You might get only *master that is good! Now switch/create a new one
`git checkout -b prototype`
The result will tell you that you have switched to a new branch also instead of prototype you can choose any single word


### Update your project
`git pull origin master`
```
remote: Counting objects: 16, done.
remote: Compressing objects: 100% (11/11), done.
remote: Total 16 (delta 5), reused 0 (delta 0), pack-reused 4
Unpacking objects: 100% (16/16), done.
From github.com:rounakpolley/Ebook_Manager
 * branch            master     -> FETCH_HEAD
   16ccc9a..fe5e826  master     -> origin/master
Updating 16ccc9a..fe5e826
Fast-forward
 LICENSE       | 21 +++++++++++++++++++++
 contribute.md | 35 +++++++++++++++++++++++++++++++++++
 2 files changed, 56 insertions(+)
 create mode 100644 LICENSE
 create mode 100644 contribute.md
 ```
 
 ### Add and commit your changes
 `git add .`
 `
 git commit -m "type a commit message in quotes like mailing feature is fixed"`
 
 No need to add each file searately and then commit them...
 
 ### Push your changes and create a pull request
 `git push origin prototype`
 
 Instead of "prototype" use the nam of your branch **BUT NEVER push to `master` branch**
 Then wait for some time..
 
 After that got to https://github.com/rounakpolley/e-book-Manager/
 And select your branch name and click create a pull request (like shown in the image)
 
 https://drupal.gatech.edu/sites/default/files/inline-images/fork7.jpg


# Follow any youtube video tutorial... for more guidance
