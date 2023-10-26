#!/bin/bash

#service nginx status
curl -sI https://dev.budgetcontrol.cloud | grep "200 OK"
