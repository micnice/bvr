#######################################
# Create table pregnancyregistration  #
#######################################

CREATE TABLE pregnancyregistration (
    idreg     BIGSERIAL PRIMARY KEY,
    lmp       char(15),
    reg_date  date,
    edd       char(15),
    pregnancy integer,
    parity    char(15),
    idbeneficiarymaster integer REFERENCES beneficiarymaster (idbeneficiarymaster)
);

##################################
######     migrate data      #####
##################################

insert into pregnancyregistration (lmp, reg_date, edd, pregnancy, parity, idbeneficiarymaster) (select lmp, reg_date, edd, pregnancy, parity, idbeneficiarymaster from beneficiarymaster order by reg_date ASC);


##################################
###### Alter voucher sales #######
##################################

ALTER TABLE vouchersales ADD COLUMN idreg INTEGER REFERENCES pregnancyregistration (idreg);

#################################
###### Populate idreg VS   ######
#################################

update vouchersales set idreg = pregnancyregistration.idreg from pregnancyregistration  where pregnancyregistration.voucherserial=vouchersales.voucherserial;

### Error

ERROR:  more than one row returned by a subquery used as an expression
bvr=# update vouchersales set idreg = (select p.idreg from pregnancyregistration p, beneficiarymaster b where p.idbeneficiarymaster=b.idbeneficiarymaster) FROM beneficiarymaster where vouchersales.nationalid = beneficiarymaster.nationalid;  

##### Add closed to pregnancyregistration
ALTER TABLE pregnancyregistration ADD COLUMN "closed" BOOLEAN NOT NULL DEFAULT FALSE;

##### Add closed to vouchersales
 ALTER TABLE vouchersales ADD COLUMN "closed" BOOLEAN NOT NULL DEFAULT FALSE;

## Error
Existing beneficiary not found on mobi/social_vouchersales_search.php
