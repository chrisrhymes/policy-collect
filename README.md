# Policy Collect

Imagine you have a collection of models that you are returning via an ajax call, meaning you don't have access to the `@can` blade helpers to see whether the user should be able to view, update or delete each model. 

This package offers a collection method that will go through a collection of models and check against the standard resource methods on the policy, returning whether the logged in user can perform an action. This can then be used in your JavaScript to decide which buttons to show or enable.

## Installation
```php
composer require chrisrhymes/policy-collect
```

## Usage

For example, if the policy checks an order belongs to a user whether they can view the order and the first order does belong to the user then you can do the following:

```php
$orders = Order::paginate()->policy();

echo $orders[0]->can->view; // true 
```

### Resource Methods

It will return the standard policy methods by default

```php
$orders[0]->can->view;
$orders[0]->can->update;
$orders[0]->can->delete;
$orders[0]->can->restore;
$orders[0]->can->forceDelete;
```

### Additional Policy Methods

The policy collection method also allows you to pass in an array of custom methods to check these in your policy as well.

For example, if you had a refund method on your order policy to determine who can refund the order, which only allows admin users to refund you can do the following:

```php
$orders = Order::paginate()->policy(['refund']);

echo $orders[0]->can->refund; // false
```

