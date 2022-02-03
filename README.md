# Eurokit Backend

# Project

Backend servicing Eurokit Hidraulica with an API served through static (subject to change) requests.

## Synopsis

A Symfony built backend deployed in AWS with Github Actions using a CD/CI and part developed TDD workflow

### Current issues

- Data modelling is faulty and therefore formatting CSV for database is an issue as it does not function as intended creating disparity in parsing/ data importing

- JSON object comes with multiple childs therefore not working as intended. Although this might be an easy fix by calling each child as string rather than array
