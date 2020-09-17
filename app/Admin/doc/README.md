# Admin

## Resources

### Context

Standard are 'index', 'create', 'detail', 'update', 'delete'

### Advence usage

In different situations resource has different state. 
There is a few params to describe current state.
- ->context() - current context
- ->hasModel() - resource has initialized model
- ->hasId() - resource has model with id
eg.
- in CreateController `->context() === 'create'`, `->hasModel() === true` and `->hasId() === false` 
- in IndexController at beging `->context() === 'index'`, `->hasModel() === false` and `->hasId() === false` 
  but after fetch list of resources, each resource has: `->context() === 'index'`, `->hasModel() === true` and `->hasId() === true` 

