USE movies;

DECLARE @cnt INT = 331000;
WHILE @cnt < 425000
BEGIN 
UPDATE Movie
SET cover_image = CHOOSE( (ROUND( (RAND()*16),0))+1 , 'ap.jpg', 'et.jpg', 'gh.jpg', 'ha.jpg', 'ij.jpg', 'pf.jpg', 'ti.jpg', 'at.jpg', 'be.jpg', 'bw.jpg', 'hp.jpg', 'spr.jpg', 'sw.jpg', 'tm4.jpg', 'tmx.jpg', 'tnr.jpg') 
WHERE movie_id = @cnt;
SET @cnt = @cnt+1;
END;

/*De code bij choose/random werkte niet helemaal zoals ik hoopte. Bij een aantal films bleef de cover_image leeg. Daarom nogmaals een keertje random langs de lege
velden en daarna maar de overgebleven gaten dichtplakken met de waarde titanic. Als iemand kan terugkoppelen waarom CHOOSE zo niet in 1 keer werkte dan hoor ik het graag. */


DECLARE @count INT = 331000;
WHILE @count < 425000
BEGIN 
UPDATE Movie
SET cover_image = CHOOSE( (ROUND( (RAND()*16),0))+1 , 'ap.jpg', 'et.jpg', 'gh.jpg', 'ha.jpg', 'ij.jpg', 'pf.jpg', 'ti.jpg', 'at.jpg', 'be.jpg', 'bw.jpg', 'hp.jpg', 'spr.jpg', 'sw.jpg', 'tm4.jpg', 'tmx.jpg', 'tnr.jpg') 
WHERE movie_id = @count AND cover_image is NULL;
SET @count = @count+1;
END;

UPDATE Movie
SET cover_image = 'ti.jpg'
WHERE cover_image is NULL;

UPDATE Movie
SET URL = 'ap.mp4'
WHERE cover_image = 'ap.jpg';

UPDATE Movie
SET URL = 'et.mp4'
WHERE cover_image = 'et.jpg';

UPDATE Movie
SET URL = 'gh.mp4'
WHERE cover_image = 'gh.jpg';

UPDATE Movie
SET URL = 'ha.mp4'
WHERE cover_image = 'ha.jpg';

UPDATE Movie
SET URL = 'ij.mp4'
WHERE cover_image = 'ij.jpg';

UPDATE Movie
SET URL = 'pf.mp4'
WHERE cover_image = 'pf.jpg';

UPDATE Movie
SET URL = 'ti.mp4'
WHERE cover_image = 'ti.jpg';

UPDATE Movie
SET URL = 'at.mp4'
WHERE cover_image = 'at.jpg';

UPDATE Movie
SET URL = 'be.mp4'
WHERE cover_image = 'be.jpg';

UPDATE Movie
SET URL = 'bw.mp4'
WHERE cover_image = 'bw.jpg';

UPDATE Movie
SET URL = 'hp.mp4'
WHERE cover_image = 'hp.jpg';

UPDATE Movie
SET URL = 'spr.mp4'
WHERE cover_image = 'spr.jpg';

UPDATE Movie
SET URL = 'sw.mp4'
WHERE cover_image = 'sw.jpg';

UPDATE Movie
SET URL = 'tm4.mp4'
WHERE cover_image = 'tm4.jpg';

UPDATE Movie
SET URL = 'tmx.mp4'
WHERE cover_image = 'tmx.jpg';

UPDATE Movie
SET URL = 'tnr.mp4'
WHERE cover_image = 'tnr.jpg';