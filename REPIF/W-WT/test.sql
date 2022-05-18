use wt;
        SELECT `use`.GroupNo, `use`.ScriptName, scripts.Path FROM `use`, scripts, groups
        WHERE scripts.ScriptName = `use`.ScriptName AND groups.HostName = "SB_1"
        GROUP BY `use`.GroupNo, `use`.ScriptName
