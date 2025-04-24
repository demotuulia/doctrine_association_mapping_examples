<img src="/img/doctrine.png" width="150">


# Doctrine Association Mapping Examples

### Contents

* [Introduction](#intro-section)
* [Asscociations](#associations-section)
  * [OneToOne](#one-to-one-section)
  * [OneToMany](#one-to-many-section)
  * [ManyToMany](#many-to-many-section)
  * [OneToMany Self Referencing](#one-to-many-sr-section)
* [Install](#install-section)
* [Scripts folder](scripts-folder-section)

  <a name='intro-section'></a>

## Introduction

This is an framework with full working Doctrine Map Association examples.
There is more explanation about this on my Medium page
[https://medium.com/@tantonius/doctrine-association-mapping-examples-54e69b87579e](https://medium.com/@tantonius/doctrine-association-mapping-examples-54e69b87579e).

There are examples for the associations below.

* OneToOne
* OneToMany
* ManyToMany
* OneToMany Self Referencing

You can clone this repo and run the examples in a Docker container.
See te instructions in the section "Install"

<a name='associations-section'></a>

## Associations

This examples have been built in a light Php framework.
The most important folders are below in the table. You can find them
there.


| **Folder** | **Description**                            |
| ---------- | ------------------------------------------ |
| App/Entity | Folder for the Entity classes              |
| Tests      | Folder for the Php unit tests and examples |

Below are the entities and tests of each association.

<a name='one-to-one-section'></a>

### OneToOne

#### Entities
Customer:
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Customer.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Customer.php)\
Cart:
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Cart.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Cart.php)

#### Test and Example
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/OneToOneTest.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/OneToOneTest.php)

<a name='one-to-many-section'></a>

### OneToMany

#### Entities
Product:
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Product.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Product.php)\
Feature:
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Feature.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Feature.php)

#### Test and Example
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/OneToManyTest.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/OneToManyTest.php)

<a name='many-to-many-section'></a>

### manyToMany

#### Entities
User:
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/User.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/User.php)\
PhoneNumber:
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/PhoneNumber.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/PhoneNumber.php)

#### Test and Example
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/ManyToManyTest.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/ManyToManyTest.php)



<a name='one-to-many-sr-section'></a>

### OneToMany Self Referencing

#### Entities
Category:
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Category.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/App/Entity/Category.php)\


#### Test and Example
[https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/OneToManySelfReferencingTest.php](https://github.com/demotuulia/doctrine_association_mapping_examples/blob/main/Tests/OneToManySelfReferencingTest.php)

<a name='install-section'></a>

# Install

## Clone the Repo

Clone this repo by 
```
git clone https://github.com/demotuulia/doctrine_association_mapping_examples.git
```

## Create containers

Create containers by the command

```
docker compose up -d
```

## Install vendor files

```
# access to the php container
docker exec --privileged -it  doctrine_association_mapping_php bash
# install by composer
composer install
```

## Test with php unit

```
# access to the php container
docker exec --privileged -it  doctrine_association_mapping_php bash
#  run the tests 
./scripts/phpunit.sh 
```

<a name='scripts-folder-section'></a>

# Scripts folder

In the folder 'scripts' I have some useful scripts for Mac and Linux.
Before you use them, make sure you have execution permissions and
execute the commands from the root folder.

```
sudo chmod a+x scripts/*
```

```
# Start the docker containers
./scripts/dockerRun.sh

# Access the Php container 
# (docker exec --privileged -it  doctrine_association_mapping_php bash)
./scripts/ssh.sh

# Run php tests. 
# (First you need to access the PHP CONTAINER  by the command./scripts/ssh.sh
./scripts/phpunit.sh

# Open the MySql command line.
# (Use this command in your HOST COMPUTER)
./scripts/mysql.sh
```
