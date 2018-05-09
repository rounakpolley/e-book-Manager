###Get your copy
`git clone https://github.com/rounakpolley/e-book-Manager.git`
or use ssh
`git clone git@github.com:rounakpolley/e-book-Manager.git`
or download zip

###Check your project status
`git status` you should get something like
```
On branch feature
nothing to commit, working directory clean
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

###Initalize git VCS and add remote
`git init`
Followed by
`git remote add https://github.com/rounakpolley/e-book-Manager.git`
or if you are using ssh
`git remote add git@github.com:rounakpolley/e-book-Manager.git`
If you did a different output for `git remote -v` then also  you need to follow the `git remote add`
