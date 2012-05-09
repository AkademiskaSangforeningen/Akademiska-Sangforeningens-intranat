/*
 '1f0ed40d-7203-11e1-abc6-88ae1d113b5e', 'pekka', 
 '1f0f5a3a-7203-11e1-abc6-88ae1d113b5e', 'alfons',  
 '1f0fca8c-7203-11e1-abc6-88ae1d113b5e', 'bert', '  
 '1f180152-7203-11e1-abc6-88ae1d113b5e', 'carl', '  
 '1f1863f5-7203-11e1-abc6-88ae1d113b5e', 'david',   
 '1f18c95a-7203-11e1-abc6-88ae1d113b5e', 'edward',    
*/

INSERT INTO `Transaction` (`Id`, `PersonId`, `TransactionDate`, `Amount`, `Description`, `PaymentTypeId`, `Created`, `CreatedBy`) VALUES (UUID(), '1f0ed40d-7203-11e1-abc6-88ae1d113b5e', NOW(), 34.00, 'Kräftiskeikka', '235a2641-7203-11e1-abc6-88ae1d113b5e', NOW(), '89fb6438-6aae-11e1-a06a-e81132589e91');
INSERT INTO `Transaction` (`Id`, `PersonId`, `TransactionDate`, `Amount`, `Description`, `PaymentTypeId`, `Created`, `CreatedBy`) VALUES (UUID(), '1f0ed40d-7203-11e1-abc6-88ae1d113b5e', NOW(), 34.00, 'Begravning', '235a2641-7203-11e1-abc6-88ae1d113b5e', NOW(), '89fb6438-6aae-11e1-a06a-e81132589e91');
INSERT INTO `Transaction` (`Id`, `PersonId`, `TransactionDate`, `Amount`, `Description`, `PaymentTypeId`, `Created`, `CreatedBy`) VALUES (UUID(), '1f0f5a3a-7203-11e1-abc6-88ae1d113b5e', NOW(), 24.00, 'Dubbelkvartettkeikka', '235a2641-7203-11e1-abc6-88ae1d113b5e', NOW(), '89fb6438-6aae-11e1-a06a-e81132589e91');

INSERT INTO `Transaction` (`Id`, `PersonId`, `TransactionDate`, `Amount`, `Description`, `PaymentTypeId`, `Created`, `CreatedBy`) VALUES (UUID(), '1f0f5a3a-7203-11e1-abc6-88ae1d113b5e', NOW(), 34.00, 'Kräftiskeikka', '235a2641-7203-11e1-abc6-88ae1d113b5e', NOW(), '89fb6438-6aae-11e1-a06a-e81132589e91');