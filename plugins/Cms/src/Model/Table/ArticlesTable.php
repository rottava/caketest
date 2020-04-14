<?php
declare(strict_types=1);

namespace Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Utility\Text;
use Cake\Event\EventInterface;

/**
 * Articles Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Article newEmptyEntity()
 * @method \App\Model\Entity\Article newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Article get($primaryKey, $options = [])
 * @method \App\Model\Entity\Article findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Article[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Article|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArticlesTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('articles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cms.Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Cms.Comments', [
            'foreignKey' => 'article_id',
        ]);
        $this->hasMany('Cms.Pics', [
            'foreignKey' => 'article_id',
        ]);
        $this->belongsToMany('Cms.Tags', [
            'foreignKey' => 'article_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'articles_tags',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('body')
            ->allowEmptyString('body');

        $validator
            ->boolean('published')
            ->allowEmptyString('published');

        $validator
            ->integer('views')
            ->allowEmptyString('views');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
		$rules->add($rules->isUnique(['addr']));
		$rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
	
	public function beforeSave(EventInterface $event, $entity, $options) {
		if ($entity->tag_string) {
			$entity->tags = $this->_buildTags($entity->tag_string);
		}
		if ($entity->isNew() && !$entity->addr) {
			$addrTitle = Text::slug($entity->title);
			$entity->addr = substr($addrTitle, 0, 255);
		}
		if ($entity->pic) {
			$entity->pics = $this->_buildPics($entity->pic, $entity->user_id);
		}
	}
	
	protected function _buildPics($pic, $uid) {
		$path = ROOT . DS . 'images';
			
		if(!is_dir($path)) {
            mkdir($path,0777);
        }
			
		$ac = $this->find()->count();
		$fullpath =  $path.'/'.$uid.'a'.$ac.'.jpg';
		
		$pic->moveTo($fullpath);
		$out[] = $this->Pics->newEntity(['path' => $fullpath]);
		
		return $out;
	}

	protected function _buildTags($tagString) {
		// Trim tags
		$newTags = array_map('trim', explode(',', $tagString));
		// Remove all empty tags
		$newTags = array_filter($newTags);
		// Reduce duplicated tags
		$newTags = array_unique($newTags);

		$out = [];
		$query = $this->Tags->find()
			->where(['Tags.title IN' => $newTags]);

		// Remove existing tags from the list of new tags.
		foreach ($query->extract('title') as $existing) {
			$index = array_search($existing, $newTags);
			if ($index !== false) {
				unset($newTags[$index]);
			}
		}
		// Add existing tags.
		foreach ($query as $tag) {
			$out[] = $tag;
		}
		// Add new tags.
		foreach ($newTags as $tag) {
			$out[] = $this->Tags->newEntity(['title' => $tag]);
		}
		return $out;
	}
}
